<?php

namespace App\Transformers\User;

use App\Models\Admin\UserDriverNotification;
use App\Models\User;
use App\Base\Constants\Auth\Role;
use App\Transformers\Transformer;
use App\Transformers\Access\RoleTransformer;
use App\Transformers\Requests\TripRequestTransformer;
use App\Models\Admin\Sos;
use App\Transformers\Common\SosTransformer;
use App\Transformers\User\FavouriteLocationsTransformer;
use App\Base\Constants\Setting\Settings;
use Carbon\Carbon;
use App\Transformers\ServiceLocationTransformer;
use App\Transformers\User\ZoneTransformer;
use App\Transformers\User\AirportTransformer;

class DispatcherTransformer extends Transformer
{
    /**
     * Resources that can be included if requested.
     *
     * @var array
     */
    protected array $availableIncludes = [ 'serviceLocation','zone','airport'
    ];
    /**
     * Resources that can be included default.
     *
     * @var array
     */
    protected array $defaultIncludes = [
        ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        $params = [
            'id' => $user->id,
            'name' => $user->name,
            'last_name' => $user->last_name,
            'username' => $user->username,
            'email' => $user->email,
            'mobile' => $user->countryDetail->dial_code.$user->mobile,
            'profile_picture' => $user->profile_picture,
            'active' => $user->active,
            'email_confirmed' => $user->email_confirmed,
            'mobile_confirmed' => $user->mobile_confirmed,
            'last_known_ip' => $user->last_known_ip,
            'last_login_at' => $user->last_login_at,
            'rating' => round($user->rating, 2),
            'no_of_ratings' => $user->no_of_ratings,
            'refferal_code'=>$user->refferal_code,
            'currency_code'=>$user->countryDetail->currency_code,
            'currency_symbol'=>$user->countryDetail->currency_symbol,
            'country_code'=>$user->countryDetail->code,
            //'map_key'=>get_settings('google_map_key'),
            'mqtt_ip'=>'54.172.163.200',
            'show_rental_ride'=>true,
            'show_ride_later_feature'=>true,
            // 'created_at' => $user->converted_created_at->toDateTimeString(),
            // 'updated_at' => $user->converted_updated_at->toDateTimeString(),
        ];

        $notifications_count= UserDriverNotification::where('user_id',$user->id)
            ->where('is_read',0)->count();
        $params['notifications_count']=$notifications_count;

        if(get_settings('show_rental_ride_feature')=='0'){
            $params['show_rental_ride'] = false;
        }
        $params['contact_us_mobile1'] =  get_settings('contact_us_mobile1');
        $params['contact_us_mobile2'] =  get_settings('contact_us_mobile2');
        $params['contact_us_link'] =  get_settings('contact_us_link');
        $params['show_wallet_feature_on_mobile_app'] =  get_settings('show_wallet_feature_on_mobile_app');
        $params['show_bank_info_feature_on_mobile_app'] =  get_settings('show_bank_info_feature_on_mobile_app');
        
        if(get_settings('show_ride_later_feature')=='0'){
            $params['show_ride_later_feature'] = false;
        }

        $referral_comission = get_settings('referral_commision_for_user');
        $referral_comission_string = 'Refer a friend and earn'.$user->countryDetail->currency_symbol.''.$referral_comission;
        $params['referral_comission_string'] = $referral_comission_string;

        $params['user_can_make_a_ride_after_x_miniutes'] = get_settings(Settings::USER_CAN_MAKE_A_RIDE_AFTER_X_MINIUTES);

        $params['maximum_time_for_find_drivers_for_regular_ride'] = (get_settings(Settings::MAXIMUM_TIME_FOR_FIND_DRIVERS_FOR_REGULAR_RIDE) * 60);
      
         $params['maximum_time_for_find_drivers_for_bitting_ride'] = (get_settings(Settings::MAXIMUM_TIME_FOR_FIND_DRIVERS_FOR_BITTING_RIDE) * 60);

        $params['enable_country_restrict_on_map'] = (get_settings(Settings::ENABLE_COUNTRY_RESTRICT_ON_MAP));
        $params['show_ride_without_destination'] = (get_settings(Settings::SHOW_RIDE_WITHOUT_DESTINATION));

        return $params;
    }


    public function includeServiceLocation(User $user)
    {

        $service_locations = $user->Admin->serviceLocationDetail;

        return $service_locations
        ? $this->item($service_locations, new ServiceLocationTransformer)
        : $this->null();

    }
    public function includeZone(User $user)
    {

        $zones = $user->Admin->serviceLocationDetail->zones;

        return $zones
        ? $this->collection($zones, new ZoneTransformer)
        : $this->null();

    }
    public function includeAirport(User $user)
    {

        $airport = $user->Admin->serviceLocationDetail->airport;

        return $airport
        ? $this->collection($airport, new AirportTransformer)
        : $this->null();

    }


}
