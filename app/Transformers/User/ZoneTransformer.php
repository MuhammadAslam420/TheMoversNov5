<?php

namespace App\Transformers\User;

use App\Transformers\Transformer;
use App\Transformers\Access\RoleTransformer;
use App\Models\Admin\ZoneType;
use App\Models\Admin\Zone;
use App\Transformers\ServiceLocationTransformer;
use App\Models\Admin\Airport;
use App\Transformers\User\AirportTransformer;

class ZoneTransformer extends Transformer
{
    /**
     * Resources that can be included if requested.
     *
     * @var array
     */
    protected array $availableIncludes = [

    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Zone $zone)
    {
        $params = [
            'id' => $zone->id,
            'name' => $zone->name,
            'active'=>$zone->active,
        ];


        return $params;
    }
   // /**
   //   * Include the roles of the user.
   //   *
   //   * @param User $user
   //   * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\NullResource
   //   */
   //  public function includeServiceLocation(Zone $zone)
   //  {

   //      $service_locations = $zone->serviceLocation;

   //      return $service_locations
   //      ? $this->item($service_locations, new ServiceLocationTransformer)
   //      : $this->null();

   //  }
   //  /**
   //   * Include the request of the user.
   //   *
   //   * @param User $user
   //   * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\NullResource
   //   */
   //  public function includeAirport()
   //  {
   //      $airport = Airport::whereActive(true)->get();

   //      return $airport
   //      ? $this->collection($airport, new AirportTransformer)
   //      : $this->null();
   //  }
}
