<?php

namespace App\Http\Controllers\Web\Admin;

use App\Base\Constants\Masters\PushEnums;
use App\Base\Constants\Masters\UserType;
use App\Http\Controllers\Controller;
use App\Jobs\Notifications\AndroidPushNotification;
use App\Models\Admin\Owner;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin\Driver;
use App\Jobs\Notifications\SendPushNotification;

class ChatController extends Controller
{


    public function index()
    {
        $page = trans('pages_names.user_chats');

        $main_menu = 'chats';
        $sub_menu = 'chat';

        
        return view('admin.chat.index', compact('page', 'main_menu', 'sub_menu'));
    }

 
}
