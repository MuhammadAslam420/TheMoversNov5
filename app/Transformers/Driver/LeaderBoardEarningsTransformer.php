<?php

namespace App\Transformers\Driver;

use App\Transformers\Transformer;

class LeaderBoardEarningsTransformer extends Transformer
{
    /**
    * Resources that can be included if requested.
    *
    * @var array
    */
    protected array $availableIncludes = [
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
     * @param DriverNeededDocument $driverneededdocument
     * @return array
     */
    public function transform($data)
    {

        // dd($data-);
        $params =  [
            'driver_id' => $data['driver_id'],
            'driver_name' => $data['name'],
            'commission' => $data['commission'],

        ];


        return $params;
    }


}
