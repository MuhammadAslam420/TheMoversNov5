<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Base\Constants\Setting\Settings as SettingSlug;
use App\Base\Constants\Setting\SettingCategory;
use App\Base\Constants\Setting\SettingSubGroup;
use App\Base\Constants\Setting\SettingValueType;

class SettingsSeeder extends Seeder
{
    /**
     * List of all the settings_from_seeder to be created along with their details.
     *
     * @var array
     */
    protected $settings_from_seeder = [

      
        SettingSlug::TRIP_DISPTACH_TYPE => [
            'category'=>SettingCategory::TRIP_SETTINGS,
            'value' => 1,
            'field' => SettingValueType::SELECT,
            'option_value' => '{"one-by-one":1,"to-all-drivers":0}',
            'group_name' => null,
        ],
        
        SettingSlug::MINIMUM_WALLET_AMOUNT_FOR_TRANSFER => [
            'category'=>SettingCategory::WALLET,
            'value' => 500,
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],

         SettingSlug::DRIVER_SEARCH_RADIUS => [
            'category'=>SettingCategory::TRIP_SETTINGS,
            'value' => 3,
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
         SettingSlug::USER_CAN_MAKE_A_RIDE_AFTER_X_MINIUTES => [
            'category'=>SettingCategory::TRIP_SETTINGS,
            'value' => 30,
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
         SettingSlug::MINIMUM_TIME_FOR_SEARCH_DRIVERS_FOR_SCHEDULE_RIDE => [
            'category'=>SettingCategory::TRIP_SETTINGS,
            'value' => 30,
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::MAXIMUM_TIME_FOR_FIND_DRIVERS_FOR_REGULAR_RIDE => [
            'category'=>SettingCategory::TRIP_SETTINGS,
            'value' => 5,
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::MAXIMUM_TIME_FOR_FIND_DRIVERS_FOR_BITTING_RIDE => [
            'category'=>SettingCategory::TRIP_SETTINGS,
            'value' => 5,
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::TRIP_ACCEPT_REJECT_DURATION_FOR_DRIVER => [
            'category'=>SettingCategory::TRIP_SETTINGS,
            'value' => 30,
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::HOW_MANY_TIMES_A_DRIVER_TIMES_A_DRIVER_CAN_ENABLE_THE_MY_ROUTE_BOOKING_PER_DAY => [
            'category'=>SettingCategory::TRIP_SETTINGS,
            'value' => 1,
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],   
        SettingSlug::ENABLE_MY_ROUTE_BOOKING_FEATURE => [
            'category'=>SettingCategory::TRIP_SETTINGS,
            'value' => 1,
             'field' => SettingValueType::SELECT,
             'option_value' => '{"yes":1,"no":0}',
             'group_name' => null,
        ],       
    //General category settings
        SettingSlug::LOGO => [
            'category'=>SettingCategory::GENERAL,
            'value' => null,
            'field' => SettingValueType::FILE,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::FAVICON => [
            'category'=>SettingCategory::GENERAL,
            'value' => null,
            'field' => SettingValueType::FILE,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::LOGINBG => [
            'category'=>SettingCategory::GENERAL,
            'value' => null,
            'field' => SettingValueType::FILE,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::NAV_COLOR => [
            'category'=>SettingCategory::GENERAL,
            'value' => '#0B4DD8',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::SIDEBAR_COLOR => [
            'category'=>SettingCategory::GENERAL,
            'value' => '#2a3042',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::SIDEBARTXT_COLOR => [
            'category'=>SettingCategory::GENERAL,
            'value' => '#a2a5af',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::APP_NAME => [
            'category'=>SettingCategory::GENERAL,
            'value' => 'Tagxi',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::CURRENCY => [
            'category'=>SettingCategory::GENERAL,
            'value' => 'INR',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::CURRENCY_SYMBOL => [
            'category'=>SettingCategory::GENERAL,
            'value' => '₹',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::DEFAULT_COUNTRY_CODE_FOR_MOBILE_APP => [
            'category'=>SettingCategory::GENERAL,
            'value' => 'IN',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::CONTACT_US_MOBILE1 => [
            'category'=>SettingCategory::GENERAL,
            'value' => '0000000000',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::CONTACT_US_MOBILE2 => [
            'category'=>SettingCategory::GENERAL,
            'value' => '0000000000',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::CONTACT_US_LINK => [
            'category'=>SettingCategory::GENERAL,
            'value' => 'https://tagxi-landing.ondemandappz.com/',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::SHOW_WALLET_FEATURE_ON_MOBILE_APP => [
            'category'=>SettingCategory::GENERAL,
             'value' => 1,
             'field' => SettingValueType::SELECT,
             'option_value' => '{"yes":1,"no":0}',
             'group_name' => null,
        ],  
        SettingSlug::SHOW_BANK_INFO_FEATURE_ON_MOBILE_APP => [
            'category'=>SettingCategory::GENERAL,
            'value' => 1,
             'field' => SettingValueType::SELECT,
             'option_value' => '{"yes":1,"no":0}',
             'group_name' => null,
        ],  
        
        SettingSlug::DRIVER_WALLET_MINIMUM_AMOUNT_TO_GET_ORDER => [
            'category'=>SettingCategory::WALLET,
            'value' => -10000,
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::OWNER_WALLET_MINIMUM_AMOUNT_TO_GET_ORDER => [
            'category'=>SettingCategory::WALLET,
            'value' => -10000,
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
       
        SettingSlug::ENABLE_STRIPE => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => '1',
            'field' => SettingValueType::SELECT,
            'option_value' => '{"yes":1,"no":0}',
            'group_name' => SettingSubGroup::STRIPE_SETTINGS,
        ],

         SettingSlug::STRIPE_ENVIRONMENT => [
            'category'=>SettingCategory::INSTALLATION,
            'field' => SettingValueType::SELECT,
             'option_value' => '{"test":"test","production":"production"}',
            'group_name' => SettingSubGroup::STRIPE_SETTINGS,
        ],

         SettingSlug::STRIPE_TEST_PUBLISHABLE_KEY => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'pk_test_51IuYWUSBCHfacuRqacrdy8IOlL3uUPq1XI0BZaRlqDPPc',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::STRIPE_SETTINGS,
        ],

        SettingSlug::STRIPE_LIVE_PUBLISHABLE_KEY => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'pk_test_51IuYWUSBCHfacuRqacrdy8IOlL3uUPq1XI0BZaRlqDPPc',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::STRIPE_SETTINGS,
        ],

        SettingSlug::STRIPE_TEST_SECRET_KEY => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'sk_test_51IuYWUSBCHfacuRqT79sG9pzvqyQqpwClyvlcrEm4ZvshYDdS5TGkYfIS2uYb',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::STRIPE_SETTINGS,
        ],

        SettingSlug::STRIPE_LIVE_SECRET_KEY => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'sk_test_51IuYWUSBCHfacuRqT79sG9pzvqyQqpwClyvlcrEm4ZvshYDdS5TGkYfIS2uYb',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::STRIPE_SETTINGS,
        ],
        SettingSlug::ENABLE_JAZZCASH => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => '1',
            'field' => SettingValueType::SELECT,
            'option_value' => '{"yes":1,"no":0}',
            'group_name' => SettingSubGroup::JAZZCASH_SETTINGS,
        ],
        SettingSlug::JAZZCASH_ENVIRONMENT => [
            'category'=>SettingCategory::INSTALLATION,
            'field' => SettingValueType::SELECT,
             'option_value' => '{"test":"test","production":"production"}',
            'group_name' => SettingSubGroup::JAZZCASH_SETTINGS,
        ],
        SettingSlug::JAZZCASH_TEST_API_URL => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'https://sandbox.jazzcash.com.pk/ApplicationAPI/API/2.0/Purchase/domwallettransaction',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => SettingSubGroup::JAZZCASH_SETTINGS,
        ],

        SettingSlug::JAZZCASH_LIVE_API_URL => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'https://sandbox.jazzcash.com.pk/ApplicationAPI/API/2.0/Purchase/domwallettransaction',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => SettingSubGroup::JAZZCASH_SETTINGS,
        ],

        SettingSlug::JAZZCASH_MARCHENT_ID => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'MC58603',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => SettingSubGroup::JAZZCASH_SETTINGS,
        ],

        SettingSlug::JAZZCASH_SALT_ID => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'zut5170cyv',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => SettingSubGroup::JAZZCASH_SETTINGS,
        ],
        SettingSlug::JAZZCASH_PASSWORD => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => '329g82w24z',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => SettingSubGroup::JAZZCASH_SETTINGS,
        ],

        SettingSlug::ENABLE_PAYSTACK => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => '1',
            'field' => SettingValueType::SELECT,
            'option_value' => '{"yes":1,"no":0}',
            'group_name' => SettingSubGroup::PAYSTACK_SETTINGS,
        ],
        SettingSlug::PAYSTACK_ENVIRONMENT => [
            'category'=>SettingCategory::INSTALLATION,
            'field' => SettingValueType::SELECT,
             'option_value' => '{"test":"test","production":"production"}',
            'group_name' => SettingSubGroup::PAYSTACK_SETTINGS,
        ],
        SettingSlug::PAYSTACK_TEST_SECRET_KEY => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'sk_test_afe3ea4a86db618f2615',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::PAYSTACK_SETTINGS,
        ],
        SettingSlug::PAYSTACK_PRODUCTION_SECRET_KEY => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'sk_test_afe3ea4a86db618f2615',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::PAYSTACK_SETTINGS,
        ],

        SettingSlug::PAYSTACK_TEST_PUBLISHABLE_KEY => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'pk_test_b4cb479fa0d654cb6db52663b',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::PAYSTACK_SETTINGS,
        ],
        SettingSlug::PAYSTACK_PRODUCTION_PUBLISHABLE_KEY => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'pk_test_b4cb479fa0d654cb6db52663b',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::PAYSTACK_SETTINGS,
        ],
        SettingSlug::ENABLE_FLUTTER_WAVE => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => '1',
            'field' => SettingValueType::SELECT,
            'option_value' => '{"yes":1,"no":0}',
            'group_name' => SettingSubGroup::FLUTTERWAVE_SETTINGS,
        ],
         SettingSlug::FLUTTER_WAVE_ENVIRONMENT => [
            'category'=>SettingCategory::INSTALLATION,
            'field' => SettingValueType::SELECT,
             'option_value' => '{"test":"test","production":"production"}',
            'group_name' => SettingSubGroup::FLUTTERWAVE_SETTINGS,
        ],
        SettingSlug::FLUTTER_WAVE_TEST_SECRET_KEY => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'FLWPUBK_TEST-9e6ca8625f1660a2-X',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::FLUTTERWAVE_SETTINGS,
        ],
        SettingSlug::FLUTTER_WAVE_PRODUCTION_SECRET_KEY => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'FLWPUBK_TEST-9e6ca8625f1660a2-X',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::FLUTTERWAVE_SETTINGS,
        ],

        SettingSlug::ENABLE_CASH_FREE => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => '1',
            'field' => SettingValueType::SELECT,
            'option_value' => '{"yes":1,"no":0}',
            'group_name' => SettingSubGroup::CASH_FREE_SETTINGS,
        ],
        SettingSlug::CASH_FREE_ENVIRONMENT => [
            'category'=>SettingCategory::INSTALLATION,
            'field' => SettingValueType::SELECT,
             'option_value' => '{"test":"test","production":"production"}',
            'group_name' => SettingSubGroup::CASH_FREE_SETTINGS,
        ],
        SettingSlug::CASH_FREE_TEST_APP_ID => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => '159508ae34a76191df96df',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::CASH_FREE_SETTINGS,
        ],
        SettingSlug::CASH_FREE_PRODUCTION_APP_ID => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => '159508ae34a76191df96df',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::CASH_FREE_SETTINGS,
        ],
            SettingSlug::CASH_FREE_SECRET_KEY => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => '9fbbd7bf43e9470cb3cc6e6a3',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::CASH_FREE_SETTINGS,
        ],
        SettingSlug::CASH_FREE_PRODUCTION_SECRET_KEY => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => '9fbbd7bf43e9470cb3cc6e6a3',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::CASH_FREE_SETTINGS,
        ],

        SettingSlug::ENABLE_RAZOR_PAY => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => '1',
            'field' => SettingValueType::SELECT,
            'option_value' => '{"yes":1,"no":0}',
            'group_name' => SettingSubGroup::RAZOR_PAY_SETTINGS,
        ],

         SettingSlug::RAZOR_PAY_ENVIRONMENT => [
            'category'=>SettingCategory::INSTALLATION,
            'field' => SettingValueType::SELECT,
            'option_value' => '{"test":"test","production":"production"}',
            'group_name' => SettingSubGroup::RAZOR_PAY_SETTINGS,
        ],

        SettingSlug::RAZOR_PAY_TEST_API_KEY => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'rzp_test_L58',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::RAZOR_PAY_SETTINGS,
        ],
        SettingSlug::RAZOR_PAY_LIVE_API_KEY => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'rzp_test_L58',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::RAZOR_PAY_SETTINGS,
        ],
        SettingSlug::RAZOR_PAY_SECRET_KEY => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'nj6DvjQh5XF8SV',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::RAZOR_PAY_SETTINGS,
        ],
        SettingSlug::RAZOR_PAY_PRODUCTION_SECRET_KEY => [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'nj6DvjQh5XF8SV',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::RAZOR_PAY_SETTINGS,
        ],
/*ccavenue*/
        SettingSlug::ENABLE_CCAVENUE=> [
            'category'=>SettingCategory::INSTALLATION,
            'value' => '1',
            'field' => SettingValueType::SELECT,
            'option_value' => '{"yes":1,"no":0}',
            'group_name' => SettingSubGroup::CCAVENUE_SETTINGS,
        ],
        SettingSlug::WORKING_KEY=> [
            'category'=>SettingCategory::INSTALLATION,
            'value' => '679B1A4387D10902995FC11',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::CCAVENUE_SETTINGS,
        ],
        SettingSlug::ACCESS_CODE=> [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'AVWH88F85HWFB',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::CCAVENUE_SETTINGS,
        ],
        SettingSlug::MERCHANT_ID=> [
            'category'=>SettingCategory::INSTALLATION,
            'value' => '988',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::CCAVENUE_SETTINGS,
        ],
        SettingSlug::RESPONSE_URL=> [
            'category'=>SettingCategory::INSTALLATION,
            'value' => 'https://your-base-url/api/v1/ccavenue/webhook',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => SettingSubGroup::CCAVENUE_SETTINGS,
        ],

        SettingSlug::REFERRAL_COMMISION_FOR_USER => [
            'category'=>SettingCategory::REFERRAL,
            'value' => 30,
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
          SettingSlug::REFERRAL_COMMISION_FOR_DRIVER => [
            'category'=>SettingCategory::REFERRAL,
            'value' => 30,
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],

        SettingSlug::GOOGLE_MAP_KEY => [
            'category'=>SettingCategory::MAP_SETTINGS,
            'value' => 'AIzaSyB4KttZBNVcz-3h2Qk8RA3Y',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::GOOGLE_MAP_KEY_FOR_DISTANCE_MATRIX => [
            'category'=>SettingCategory::MAP_SETTINGS,
            'value' => 'AIzaSyBeVRs1icwooRpk7ErjCE',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::GOOGLE_SHEET_ID => [
            'category'=>SettingCategory::MAP_SETTINGS,
            'value' => '1sOIs6oiLv-xrc3cXoux2MZJE_gdnBT7co',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::DEFAULT_LAT => [
            'category'=>SettingCategory::MAP_SETTINGS,
            'value' => 11.21215,
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::DEFAULT_LONG => [
            'category'=>SettingCategory::MAP_SETTINGS,
            'value' => 76.54545,
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
         SettingSlug::FIREBASE_DB_URL => [
            'category'=>SettingCategory::FIREBASE_SETTINGS,
            'value' => 'https://your-db.firebaseio.com',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
         SettingSlug::FIREBASE_API_KEY => [
            'category'=>SettingCategory::FIREBASE_SETTINGS,
            'value' => 'your-api-key',
            'field' => SettingValueType::PASSWORD,
            'option_value' => null,
            'group_name' => null,
        ],
           SettingSlug::FIREBASE_AUTH_DOMAIN => [
            'category'=>SettingCategory::FIREBASE_SETTINGS,
            'value' => 'your-auth-domain',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
         SettingSlug::FIREBASE_PROJECT_ID => [
            'category'=>SettingCategory::FIREBASE_SETTINGS,
            'value' => 'your-firebase-project-id',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
         SettingSlug::FIREBASE_STORAGE_BUCKET => [
            'category'=>SettingCategory::FIREBASE_SETTINGS,
            'value' => 'your-firebase-storage-bucket',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::FIREBASE_MESSAGIN_SENDER_ID => [
            'category'=>SettingCategory::FIREBASE_SETTINGS,
            'value' => 'your-firebase-messaging-sender-id',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::FIREBASE_APP_ID => [
            'category'=>SettingCategory::FIREBASE_SETTINGS,
            'value' => 'your-app-id',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
         SettingSlug::FIREBASE_MEASUREMENT_ID => [
            'category'=>SettingCategory::FIREBASE_SETTINGS,
            'value' => 'your-firebase-measurement-id',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
         SettingSlug::CURRENCY => [
            'category'=>SettingCategory::GENERAL,
            'value' => 'INR',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::CURRENCY_SYMBOL => [
            'category'=>SettingCategory::GENERAL,
            'value' => '₹',
            'field' => SettingValueType::TEXT,
            'option_value' => null,
            'group_name' => null,
        ],
        SettingSlug::SHOW_RENTAL_RIDE_FEATURE => [
            'category'=>SettingCategory::GENERAL,
            'value' => '1',
            'field' => SettingValueType::SELECT,
            'option_value' => '{"yes":1,"no":0}',
            'group_name' => null,
        ],
         SettingSlug::SHOW_RIDE_OTP_FEATURE => [
            'category'=>SettingCategory::GENERAL,
            'value' => '1',
            'field' => SettingValueType::SELECT,
            'option_value' => '{"yes":1,"no":0}',
            'group_name' => null,
        ],
         SettingSlug::SHOW_RIDE_LATER_FEATURE => [
            'category'=>SettingCategory::GENERAL,
            'value' => '1',
            'field' => SettingValueType::SELECT,
            'option_value' => '{"yes":1,"no":0}',
            'group_name' => null,
        ],
         SettingSlug::SHOW_RIDE_WITHOUT_DESTINATION => [
            'category'=>SettingCategory::GENERAL,
            'value' => '1',
            'field' => SettingValueType::SELECT,
            'option_value' => '{"yes":1,"no":0}',
            'group_name' => null,
        ],
        SettingSlug::ENABLE_COUNTRY_RESTRICT_ON_MAP => [
            'category'=>SettingCategory::GENERAL,
            'value' => '0',
            'field' => SettingValueType::SELECT,
            'option_value' => '{"yes":1,"no":0}',
            'group_name' => null,
        ],
       /*Mailer Name*/
        SettingSlug::MAIL_MAILER => [
            'category'=>SettingCategory::MAIL_CONFIGURATION,
            'value' => 'smtp',
            'field' => SettingValueType::TEXT,
            'group_name' => null,
        ],
        SettingSlug::MAIL_HOST => [
            'category'=>SettingCategory::MAIL_CONFIGURATION,
            'value' => 'smtp.gmail.com',
            'field' => SettingValueType::TEXT,
            'group_name' => null,
        ],
        SettingSlug::MAIL_PORT => [
            'category'=>SettingCategory::MAIL_CONFIGURATION,
            'value' => '587',
            'field' => SettingValueType::TEXT,
            'group_name' => null,
        ],
        SettingSlug::MAIL_USERNAME => [
            'category'=>SettingCategory::MAIL_CONFIGURATION,
            'value' => 'misoftwares2021@gmail.com',
            'field' => SettingValueType::PASSWORD,
            'group_name' => null,
        ],
        SettingSlug::MAIL_PASSWORD => [
            'category'=>SettingCategory::MAIL_CONFIGURATION,
            'value' => 'slmhqzznbrimvbda',
            'field' => SettingValueType::PASSWORD,
            'group_name' => null,
        ],
        SettingSlug::MAIL_ENCRYPTION => [
            'category'=>SettingCategory::MAIL_CONFIGURATION,
            'value' => 'tls',
            'field' => SettingValueType::TEXT,
            'group_name' => null,
        ],    
        SettingSlug::MAIL_FROM_ADDRESS => [
            'category'=>SettingCategory::MAIL_CONFIGURATION,
            'value' => 'misoftwares2021@gmail.com',
            'field' => SettingValueType::TEXT,
            'group_name' => null,
        ], 
         SettingSlug::MAIL_FROM_NAME => [
            'category'=>SettingCategory::MAIL_CONFIGURATION,
            'value' => 'misoftwares',
            'field' => SettingValueType::TEXT,
            'group_name' => null,
        ],             
    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settingDB = Setting::all();

        foreach ($this->settings_from_seeder as $setting_slug=>$setting) {
            $categoryFound = $settingDB->first(function ($one) use ($setting_slug) {
                return $one->name === $setting_slug;
            });

            $created_params = [
                        'name' => $setting_slug
                    ];

            $to_create_setting_data = array_merge($created_params, $setting);

            if (!$categoryFound) {
                Setting::create($to_create_setting_data);
            }
        }
    }
}
