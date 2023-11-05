<?php

namespace App\Http\Controllers\Api\V1\Request;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use App\Jobs\NotifyViaMqtt;
use App\Models\Admin\Driver;
use App\Jobs\NotifyViaSocket;
use App\Models\Admin\ZoneType;
use App\Models\Request\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Request\RequestMeta;
use Illuminate\Support\Facades\Log;
use App\Base\Constants\Masters\PushEnums;
use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\Request\UpdateTripRequest;
use App\Jobs\Notifications\AndroidPushNotification;
use App\Transformers\Requests\TripRequestTransformer;
use App\Jobs\Notifications\FcmPushNotification;
use App\Base\Constants\Setting\Settings;
use Sk\Geohash\Geohash;
use Kreait\Firebase\Database;
use App\Jobs\Notifications\SendPushNotification;
use Illuminate\Http\Request as ValidatorRequest;


/**
 * @group User-trips-apis
 *
 * APIs for User-trips apis
 */
class UpdateRequestController extends BaseController
{
    protected $request;

    public function __construct(Request $request,Database $database)
    {
        $this->request = $request;
        $this->database = $database;
    }
    /**
    * Create Request
    * @bodyParam pick_lat double required pikup lat of the user
    * @bodyParam pick_lng double required pikup lng of the user
    * @bodyParam drop_lat double required drop lat of the user
    * @bodyParam drop_lng double required drop lng of the user
    * @bodyParam drivers json required drivers json can be fetch from firebase db
    * @bodyParam vehicle_type string required id of zone_type_id
    * @bodyParam payment_opt tinyInteger required type of ride whther cash or card, wallet('0 => card,1 => cash,2 => wallet)
    * @bodyParam pick_address string required pickup address of the trip request
    * @bodyParam drop_address string required drop address of the trip request
    * @bodyParam is_later tinyInteger sometimes it represent the schedule rides param must be 1.
    * @bodyParam trip_start_time timestamp sometimes it represent the schedule rides param must be datetime format:Y-m-d H:i:s.
    * @bodyParam promocode_id uuid optional id of promo table
    * @bodyParam rental_pack_id integer optional id of package type
    * @responseFile responses/requests/create-request.json
    *
    */
    public function updateRequest(UpdateTripRequest $request)
    {

        if($request->has('payment_opt') && $request->payment_opt){

           $request_params['payment_opt'] = $request->payment_opt;

        }

        $request_detail = Request::where('id', $request->request_id)->first();

        $request_detail->update($request_params);

        return $this->respondSuccess($request_detail, 'payment_option_updated_successfully');
    }





}
