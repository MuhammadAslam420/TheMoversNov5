<?php

namespace App\Transformers\User;

use App\Transformers\Transformer;
use App\Transformers\Access\RoleTransformer;
use App\Models\Admin\ZoneType;
use App\Models\Admin\Zone;
use App\Transformers\ServiceLocationTransformer;
use App\Models\Admin\Airport;

class AirportTransformer extends Transformer
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
    public function transform(Airport $airport)
    {
        $params = [
            'id' => $airport->id,
            'name' => $airport->name,
            'active'=>$airport->active,
        ];


        return $params;
    }
 
}
