<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Profile;
use App\Models\Notifications\Notification;
use App\Models\Chat\MessageNotification;
use App\Models\Chat\Message;
use App\Models\Chat\Conversation;
use View;

class Controller extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Parent All Controllers
    |--------------------------------------------------------------------------
    |
    | This controller acts as the parent model for 
    | application's all Controllers. But still is the child of
    | the Base Controller.
    |
    */

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Makes necessary security checkings as well as 
     * shares variables among the views.
     */
    public function __construct() {
        $this->middleware('auth');
        $authenticatedUser = Auth::user();

        if($authenticatedUser){
            $this->isBlocked($authenticatedUser);
            $this->isIpAllowed($authenticatedUser);
            
            $notifications = Notification::where('user_id', $authenticatedUser->id)->orderBy('created_at', 'DESC')->limit(10)->get();
            $unreadNotificationCount = Notification::where('user_id', $authenticatedUser->id)->where('isRead', 'false')->count();
            $unreadMessageCount = Message::where('recipient_id', $authenticatedUser->id)->where('isRead', 'false')->count();
            $chatters = User::where('id', '!=', $authenticatedUser->id)->get();

            View::share(array(
                'notifications' => $notifications, 
                'unreadNotificationCount' => $unreadNotificationCount, 
                'unreadMessageCount' => $unreadMessageCount, 
                'chatters' => $chatters, 
            ));
        }
        View::share(array(
            'l' => config('app.locale'), 
        ));
    }  


    /**
     * Check if given user is blocked.
     *
     * @return  \Illuminate\Http\Response
     */
    private static function isBlocked($authenticatedUser){
        if($authenticatedUser->profile->isBlocked){
            abort('423');
        }
    }

    /**
     * Check if given user is allowed to access the application from his/her IP.
     *
     * @return  \Illuminate\Http\Response
     */
    private static function isIpAllowed($authenticatedUser){
        if($authenticatedUser->profile->servers->contains('address', \Request::ip()) == false){
            abort('401');
        }
    }

    /**
     * Check if given permission exists for user's role.
     *
     * @return  \Illuminate\Http\Response
     */
    public static function checkPermission($permissionName){
        if(Auth::user() && !Auth::user()->roles[0]->permissions->contains('name', $permissionName)){
            abort('403');
        }
    }
}
