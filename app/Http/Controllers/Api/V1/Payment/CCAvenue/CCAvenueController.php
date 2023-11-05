<?php

namespace App\Http\Controllers\Api\V1\Payment\CCAvenue;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Base\Constants\Auth\Role;
use App\Http\Controllers\ApiController;
use App\Models\Payment\UserWalletHistory;
use App\Models\Payment\DriverWalletHistory;
use App\Transformers\Payment\WalletTransformer;
use App\Transformers\Payment\DriverWalletTransformer;
use App\Http\Requests\Payment\AddMoneyToWalletRequest;
use App\Transformers\Payment\UserWalletHistoryTransformer;
use App\Transformers\Payment\DriverWalletHistoryTransformer;
use App\Models\Payment\UserWallet;
use App\Models\Payment\DriverWallet;
use App\Base\Constants\Masters\WalletRemarks;
use App\Base\Constants\Setting\Settings;
use App\Jobs\Notifications\AndroidPushNotification;
use App\Jobs\NotifyViaMqtt;
use App\Base\Constants\Masters\PushEnums;
use App\Models\Payment\OwnerWallet;
use App\Models\Payment\OwnerWalletHistory;
use App\Transformers\Payment\OwnerWalletTransformer;
use App\Models\Request\Request as RequestModel;
use Kreait\Firebase\Database;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Jobs\Notifications\SendPushNotification;
use Kishnio\CCAvenue\Payment as CCAvenueClient;
include 'Crypto.php';

/**
 * @group Paystack Payment Gateway
 *
 * Payment-Related Apis
 */
class CCAvenueController extends ApiController
{

     public function __construct(Database $database)
    {
        $this->database = $database;
    }
    /**
     * Initialize Payment
     * 
     * 
     * 
     * */
    public function initialize(Request $request){

$merchant_data = '';
$working_key =   get_settings(Settings::WORKING_KEY);  //'679B1A4387D10902995FC11DE9DC7B6C'; 
$access_code = get_settings(Settings::ACCESS_CODE);  // 'AVWH88JF34BF85HWFB  ';
$merchant_id = get_settings(Settings::MERCHANT_ID);  //'987718';
$response_url = get_settings(Settings::RESPONSE_URL);  //'https://girki.co.in/api/v1/ccavenue/webhook'; 
$amount = $request->amount;

foreach ($_POST as $key => $value) {
    $merchant_data .= $key . '=' . $value . '&';
}
// // randon and unique order id with time
// $merchant_data .= "order_id=" . $order_id;

$merchant_data .= 'merchant_id=' . $merchant_id . '&';

$reference = auth()->user()->id;

$current_timestamp = Carbon::now()->timestamp;

$request_for = 'add-money-to-wallet';

if($request->has('payment_for')){

        $request_for = $request->payment_for;

}

$order_id = $current_timestamp.'ORD'.$reference.'ORD'.$request_for;

$merchant_data .= 'order_id=' . $order_id . '&';
$merchant_data .= 'redirect_url=' . $response_url . '&';
$merchant_data .= 'amount='.$amount.'&';
$merchant_data .= 'currency=INR&';

$encrypted_data = encryptCC($merchant_data, $working_key);

// create json of encrypted data and access code
$access_code = urlencode($access_code);
$encrypted_data = urlencode($encrypted_data);

$data = [
    'enc_val' => $encrypted_data,
    'access_code' => $access_code,
];

    
return response()->json($data);


    }


    public function webHook(Request $request){

$working_key = '679B1A4387D10902995FC11DE9DC7B6C'; 
$encResponse = $_POST["encResp"]; // This is the response sent by the CCAvenue Server
$rcvdString = decryptCC($encResponse, $working_key); // Crypto Decryption used as per the specified working key.
$order_status = "";
$decryptValues = explode('&', $rcvdString);
$dataSize = sizeof($decryptValues);
for ($i = 0; $i < $dataSize; $i++) {
    $information = explode('=', $decryptValues[$i]);
    $responseMap[$information[0]] = $information[1];
}
$order_status = $responseMap['order_status'];
    
    
    $result = json_encode($responseMap);

    $request_result= json_decode($result,true);

    Log::info($request_result);

    $order_id = $request_result['order_id'];

    $transaction_id = $request_result['tracking_id'];

    $order_status = $request_result['order_status'];

    $status_message = $request_result['status_message'];

    $requested_amount= $request_result['amount'];

    //&& !$status_message=='Transaction Successful-NA-0'

    if($order_status!='Success'){
        goto end;

    }

    $exploded_reference = explode('ORD', $order_id);
    
    if(count($exploded_reference)<2){
            goto end;
    }

    $user_id = $exploded_reference[1];

    $user = User::find($user_id);

    if($exploded_reference[2]!='add-money-to-wallet'){

            $this->makePaymentForRide($exploded_reference[2],$transaction_id);

            goto end;
    }

    if($user==null){
            goto end;
    }

      if ($user->hasRole('user')) {
        $wallet_model = new UserWallet();
        $wallet_add_history_model = new UserWalletHistory();
        } elseif($user->hasRole('driver')) {
                    $wallet_model = new DriverWallet();
                    $wallet_add_history_model = new DriverWalletHistory();
                    $user_id = $user->driver->id;
        }else {
                    $wallet_model = new OwnerWallet();
                    $wallet_add_history_model = new OwnerWalletHistory();
                    $user_id = $user->owner->id;
        }

        $user_wallet = $wallet_model::firstOrCreate([
            'user_id'=>$user_id]);
        $user_wallet->amount_added += $requested_amount;
        $user_wallet->amount_balance += $requested_amount;
        $user_wallet->save();
        $user_wallet->fresh();

        $wallet_add_history_model::create([
            'user_id'=>$user_id,
            'amount'=>$requested_amount,
            'transaction_id'=>$transaction_id,
            'remarks'=>WalletRemarks::MONEY_DEPOSITED_TO_E_WALLET,
            'is_credit'=>true]);


            $title = trans('push_notifications.amount_credited_to_your_wallet_title',[],$user->lang);
            $body = trans('push_notifications.amount_credited_to_your_wallet_body',[],$user->lang);


            // dispatch(new SendPushNotification($user,$title,$body));

             end:

            $result = $this->respondSuccess(null,'money_added_successfully');




    }





     /**
     * Make Payment At end of the ride
     * 
     * */
    public function makePaymentForRide($request_id,$transaction_id){

        $request_detail = RequestModel::find($request_id); 

        $driver = $request_detail->driverDetail;    

        //  Update payement status
        $request_detail->is_paid = 1;

        $request_detail->save();

        $driver_commision = $request_detail->requestBill->driver_commision;

        $user_wallet = DriverWallet::firstOrCreate([
            'user_id'=>$driver->id]);

        $user_wallet->amount_added += $driver_commision;
        $user_wallet->amount_balance += $driver_commision;
        $user_wallet->save();
        $user_wallet->fresh();

        DriverWalletHistory::create([
            'user_id'=>$driver->id,
            'amount'=>$driver_commision,
            'transaction_id'=>$transaction_id,
            'remarks'=>WalletRemarks::TRIP_COMMISSION_FOR_DRIVER,
            'is_credit'=>true]);

        $this->database->getReference('requests/'.$request_detail->id)->update(['is_paid'=>1,'updated_at'=> Database::SERVER_TIMESTAMP]);

        $title = trans('push_notifications.payment_completed_by_user_title',[],$driver->user->lang);
        $body = trans('push_notifications.payment_completed_by_user_body',[],$driver->user->lang);

        dispatch(new SendPushNotification($driver->user,$title,$body));

        return;

    }


    
}
