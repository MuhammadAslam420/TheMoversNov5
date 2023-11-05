<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Country;
use App\Base\Constants\Auth\Role;

class UsersImport implements ToModel , WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */




    public function model(array $row)
    {
        
    $country_id =  Country::where('code', $row['country'])->pluck('id')->first();

        $created_params = [
            "name" => $row['name'],
            "email" => $row['email'],
            "mobile" => $row['mobile'],
            "gender" => $row['gender'],
            'country'=>$country_id,
            'refferal_code'=>str_random(6),
        ];
        
        $user = User::create($created_params);
        // Create Empty Wallet to the user
        $user->userWallet()->create(['amount_added'=>0]);

        $user->attachRole(Role::USER);

        return $user;
    }
}
