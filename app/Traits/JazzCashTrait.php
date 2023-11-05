<?php

namespace App\Traits;

use App\Base\Constants\Auth\Role;
use App\Base\Constants\Masters\PushEnums;
use App\Base\Constants\Masters\WalletRemarks;
use App\Base\Constants\Setting\Settings;
use App\Jobs\Notifications\SendPushNotification;
use App\Models\Payment\DriverWallet;
use App\Models\Payment\DriverWalletHistory;
use App\Models\Payment\OwnerWallet;
use App\Models\Payment\OwnerWalletHistory;
use App\Models\Payment\UserWallet;
use App\Models\Payment\UserWalletHistory;
use App\Transformers\Payment\DriverWalletTransformer;
use App\Transformers\Payment\OwnerWalletTransformer;
use App\Transformers\Payment\WalletTransformer;
use Illuminate\Support\Facades\Http;
trait JazzcashTrait
{
    private $apiUrl = 'https://sandbox.jazzcash.com.pk/ApplicationAPI/API/2.0/Purchase/domwallettransaction';
    protected $merchantId;
    protected $password;
    protected $salt;

    public function __construct()
    {
        $this->merchantId = get_settings(Settings::JAZZCASH_MARCHENT_ID);
        $this->password = get_settings(Settings::JAZZCASH_PASSWORD);
        $this->salt = 'zut5170cyv';
    }

    public function initiatePayment(array $data)
    {
       
            $url = $data['api_url'];
            $payload = [
                'pp_Language' => 'EN',
                'pp_MerchantID' => $this->merchantId,
                'pp_SubMerchantID' => '',
                'pp_Password' => $this->password,
                'pp_TxnRefNo' => $data['transaction_id'],
                'pp_MobileNumber' => $data['phone'],
                "pp_CNIC" => $data['cnic'],
                'pp_Amount' => $data['order_amount'],
                "pp_DiscountedAmount" => '',
                'pp_TxnCurrency' => 'PKR',
                'pp_TxnDateTime' => date('YmdHis'),
                'pp_BillReference' => $data['order_id'],
                'pp_Description' => $data['description'],
                'pp_TxnExpiryDateTime' => date('YmdHis', strtotime('+2 days')),
                'pp_SecureHash' => '',
                'ppmpf_1' => $data['phone'],
                'ppmpf_2' => $data['user_id'],
                'ppmpf_3' => $data['order_id'],
                'ppmpf_4' => $data['order_amount'],
                'ppmpf_5' => $data['user_id'],
            ];

            $pp_SecureHash = $this->get_SecureHash($payload);
            $payload['pp_SecureHash'] = $pp_SecureHash;
            $response = Http::post($url, $payload);
              return $response->json();
       
       
    }

    private function get_SecureHash($data_array)
    {
        ksort($data_array);

        $str = '';
        foreach ($data_array as $key => $value) {
            if (!empty($value)) {
                $str .= '&' . $value;
            }
        }

        $str = $this->salt . $str;

        $pp_SecureHash = hash_hmac('sha256', $str, $this->salt);

        return $pp_SecureHash;
    }

    public function verifiedTransaction(array $data)
    {
        try {
            $url = $data['api_url'];
            $payload = [
                "pp_TxnRefNo"=> $data['transaction_id'],
                "pp_MerchantID"=> "MC58603",
                "pp_Password"=> "329g82w24z",
                
            ];
            //dd($payload);
            $pp_SecureHash = $this->verified_SecureHash($payload);
            $payload['pp_SecureHash'] = $pp_SecureHash;
            
            $response = Http::post($url, $payload);
            return $response->json();
            
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., HTTP request failure, database error)
            return $e->getMessage();
        }
    }
    private function verified_SecureHash($data_array)
    {
        ksort($data_array);

        $str = '';
        foreach ($data_array as $key => $value) {
            if (!empty($value)) {
                $str .= '&' . $value;
            }
        }

        $str = 'zut5170cyv' . $str;

        $pp_SecureHash = hash_hmac('sha256', $str, 'zut5170cyv');

        return $pp_SecureHash;
    }
}
