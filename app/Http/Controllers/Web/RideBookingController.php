<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Cms\FrontPage;
use App\Jobs\Notifications\Auth\Registration\ContactusNotification;
use DB;
use Auth;
use Session;
use App\Models\Country;
use App\Models\User;


class RideBookingController extends Controller
{
  
 public function uploadPath()
    {
        return config('base.cms.upload.web-picture.path');
    }
  public function index()
  {

   $countries = Country::all();
    
     return view ('webfront.rideIndex', compact('countries'));   
  }
  public function userVerification(Request $request)
  {

   $user =  User::where('mobile', $request->mobileNumber)->exists();

    return $user;

  }   

  public function signUp()
  {
    $mobile = request()->input()->mobile;
     return view ('webfront.signup');   
  }
}
