<?php

namespace App\Http\Controllers\Api\V1\Payment\Jazzcash;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Base\Constants\Auth\Role;
use App\Models\Payment\UserWalletHistory;
use App\Models\Payment\DriverWalletHistory;
use App\Transformers\Payment\WalletTransformer;
use App\Transformers\Payment\DriverWalletTransformer;
use App\Models\Payment\DriverWallet;
use App\Base\Constants\Masters\WalletRemarks;
use App\Traits\JazzCashTrait;
use App\Models\User;
use App\Base\Constants\Masters\PushEnums;
use App\Models\Payment\UserWallet;
use App\Models\Payment\OwnerWallet;
use App\Models\Payment\OwnerWalletHistory;
use App\Transformers\Payment\OwnerWalletTransformer;
use App\Jobs\Notifications\SendPushNotification;
use App\Base\Constants\Setting\Settings;
use App\Http\Controllers\Controller;
use DB;
class JazzCashPaymentController extends Controller
{
    use JazzCashTrait;


    public function generateTransaction(Request $request)
    {
        try {
            DB::beginTransaction();
            $userId = auth()->user()->id;
            $orderAmount = $request->order_amount;
            $phone = $request->phone;
            $cnic = $request->cnic;
            $secret_key = get_settings(Settings::JAZZCASH_TEST_API_URL);
            $orderId = Carbon::now()->timestamp . $userId;
            $description = 'The Movers Cab';
            $transactionId = "T" . date('YmdHis');

            if (get_settings(Settings::JAZZCASH_ENVIRONMENT) == 'test') {
                $jazzcash_environment = true;
            } else {
                $jazzcash_environment = false;
            }

            $orderId = Carbon::now()->timestamp . auth()->user()->id;
            $response = $this->initiatePayment([
                'order_id' => $orderId,
                'order_amount' => $request->order_amount,
                'order_currency' => 'PKR',
                'phone' => $request->phone,
                'cnic' => $request->cnic,
                'user_id' => auth()->user()->id,
                'transaction_id' => "T" . date('YmdHis'),
                'description' => 'The Movers Cab',
                'api_url' => $secret_key,
            ]);
            if ($response['pp_ResponseCode'] === '000') {
                $transactionId = $response['pp_TxnRefNo'];
                $amountAdded = $response['ppmpf_4'];


                UserWalletHistory::create([
                    'user_id' => $userId,
                    'amount' => $orderAmount,
                    'transaction_id' => $transactionId,
                    'remarks' => WalletRemarks::MONEY_DEPOSITED_TO_E_WALLET,
                    'is_credit' => true
                ]);

                $userWallet = UserWallet::where('user_id', $userId)->first();

                if ($userWallet) {
                    $userWallet->update([
                        'amount_added' => $userWallet->amount_added + $amountAdded,
                        'amount_balance' => $userWallet->amount_balance + $amountAdded,
                    ]);
                } else {
                    UserWallet::create([
                        'user_id' => $userId,
                        'amount_added' => $amountAdded,
                        'amount_balance' => $amountAdded,
                        'amount_spent' => 0,
                    ]);
                }
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'error']);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }



    }



    public function addMoneyToWallet(Request $request)
    {
            $transaction_id = $request->payment_id;
            $user = auth()->user();

            if (access()->hasRole('user')) {
            $wallet_model = new UserWallet();
            $wallet_add_history_model = new UserWalletHistory();
            $user_id = auth()->user()->id;
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
        $user_wallet->amount_added += $request->amount;
        $user_wallet->amount_balance += $request->amount;
        $user_wallet->save();
        $user_wallet->fresh();

        $wallet_add_history_model::create([
            'user_id'=>$user_id,
            'amount'=>$request->amount,
            'transaction_id'=>$transaction_id,
            'remarks'=>WalletRemarks::MONEY_DEPOSITED_TO_E_WALLET,
            'is_credit'=>true]);
                $pus_request_detail = json_encode($request->all());

                $socket_data = new \stdClass();
                $socket_data->success = true;
                $socket_data->success_message  = PushEnums::AMOUNT_CREDITED;
                $socket_data->result = $request->all();

                $title = trans('push_notifications.amount_credited_to_your_wallet_title',[],$user->lang);
                $body = trans('push_notifications.amount_credited_to_your_wallet_body',[],$user->lang);

                // dispatch(new NotifyViaMqtt('add_money_to_wallet_status'.$user_id, json_encode($socket_data), $user_id));

                dispatch(new SendPushNotification($user,$title,$body));

                if (access()->hasRole(Role::USER)) {
                $result =  fractal($user_wallet, new WalletTransformer);
                } elseif(access()->hasRole(Role::DRIVER)) {
                $result =  fractal($user_wallet, new DriverWalletTransformer);
                }else{
                $result =  fractal($user_wallet, new OwnerWalletTransformer);

                }

        return $this->respondSuccess($result, 'money_added_successfully');
    }

}
