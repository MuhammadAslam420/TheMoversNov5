<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class DummyTableForTesting extends Model
{
    use SpatialTrait;

    protected $table='testing_table';

    protected $fillable = [
        'route_coordinates'
    ];


    protected $spatialFields = [
        'route_coordinates',
    ];

}
