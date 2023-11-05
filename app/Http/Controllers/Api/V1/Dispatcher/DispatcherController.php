<?php

namespace App\Http\Controllers\Api\V1\Dispatcher;

use Ramsey\Uuid\Uuid;
use App\Jobs\NotifyViaMqtt;
use App\Models\Admin\Driver;
use App\Jobs\NotifyViaSocket;
use App\Models\Admin\Zone;
use Illuminate\Http\Request as ValidatorRequest;
use App\Models\Request\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Request\RequestMeta;
use Illuminate\Support\Facades\Log;
use App\Base\Constants\Masters\PushEnums;
use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\Request\CreateTripRequest;
use App\Jobs\Notifications\AndroidPushNotification;
use App\Transformers\Requests\TripRequestTransformer;
use App\Models\User;
use App\Transformers\Requests\UserRequestForDispatcherAppTransformer;
use Sk\Geohash\Geohash;
use Kreait\Firebase\Database;
use App\Base\Constants\Auth\Role;
use Carbon\Carbon;
use App\Transformers\Dispatcher\UserForDispatcherRideTransformer;
use App\Jobs\Notifications\SendPushNotification;
use App\Transformers\User\ZoneTransformer;

/**
 * @group Dispatcher-trips-apis
 *
 * APIs for Dispatcher-trips apis
 */
class DispatcherController extends BaseController
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
    * @bodyParam vehicle_type string required id of zone_type_id
    * @bodyParam payment_opt tinyInteger required type of ride whther cash or card, wallet('0 => card,1 => cash,2 => wallet)
    * @bodyParam pick_address string required pickup address of the trip request
    * @bodyParam drop_address string required drop address of the trip request
    * @responseFile responses/requests/create-request.json
    *
    */
   public function zone()
   {

      $zones = Zone::whereActive(true)->get();

        $zone = fractal($zones, new ZoneTransformer)->parseIncludes(['airport', 'serviceLocation']);
     
        // dd($zones);

        return $this->respondOk($zone);

   }
}
