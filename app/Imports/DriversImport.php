<?php

namespace App\Imports;

use App\Models\Admin\Driver;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Country;
use App\Base\Constants\Auth\Role;
use App\Models\Admin\ServiceLocation;
use App\Models\Admin\Company;
use App\Models\Master\CarMake;
use App\Models\Master\CarModel;
use App\Models\Admin\VehicleType;

class DriversImport implements ToModel , WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */




    public function model(array $row)
    {
        
        // $country_id =  Country::where('code', $row['country'])->pluck('id')->first();
        $service_locations = ServiceLocation::where('country' , $row['service_locations'])->pluck('id')->first();
        $types = VehicleType::where('name' , $row['vehicletype'])->pluck('id')->first();
        $carmake = CarMake::where('name' , $row['carmake'])->pluck('id')->first();
        $carmodel = CarModel::where('name' , $row['carmodel'])->pluck('id')->first();
        $user_id = User::where('name', $row['user'])->pluck('id')->first();

        $created_params = [
            // "user_id" => $user_id,
            "name" => $row['name'],
            "email" => $row['email'],
            "mobile" => $row['mobile'],
            "gender" => $row['gender'],
            "car_color" => $row['car_color'],
            "car_number" => $row['car_number'],
            'service_locations'=>$service_locations,
            'types'=>$types,
            'carmake' =>$carmake,
            'carmodel' => $carmodel,
            'user' =>$user_id,
            'refferal_code'=>str_random(6),
        ];
        
        $driver = Driver::create($created_params);
        // Create Empty Wallet to the user
        $driver->userWallet()->create(['amount_added'=>0]);

        
        $user->attachRole(RoleSlug::DRIVER);

        return $driver;
    }
}
