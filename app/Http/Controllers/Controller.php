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
use Carbon\Carbon;
use View;
use File;
use Image;

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
       
        $ip = \Request::ip(); 

        if(Auth::user() && Auth::user()->profile->isBlocked){
		    abort('423');
    	}

        if(Auth::user() && Auth::user()->profile->servers->contains('address', $ip) == false){
            abort('401');
        }

      	$l = \Config::get('app.locale'); 
        if(Auth::user()){
            $notifications = Notification::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->limit(10)->get();
            $unread = Notification::where('user_id', Auth::user()->id)->where('isRead', 'false')->count();
            $unreadMsg = Message::where('recipient_id', Auth::user()->id)->where('isRead', 'false')->count();
            $chatters = User::where('id', '!=', \Auth::user()->id)->get();
        }else{
            $notifications = '';
            $unread = '';
            $unreadMsg = '';
            $chatters = '';
        }
		View::share(array(
            'l' => $l, 
            'notifications' => $notifications, 
            'unread' => $unread, 
            'unreadMsg' => $unreadMsg, 
            'chatters' => $chatters, 
		));
    }  

    /**
     * Crop and upload a profile picture after deleting 
     * existing photo of the user
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \Illuminate\Support\Facades\File
     * @param   \Intervention\Image\Facades\Image
     * @param   \App\Profile $profile
     * @param   \Illuminate\Session\Store flash()
     * @return  boolean
     */
    public static function cropAndUploadProfilePhoto($profile, $request){
        $profile = Profile::find($profile);
        $filename = time().'userprofile'.$profile->id;
        File::delete($profile->photo);

        $x = round($request->get('x'));
        $y = round($request->get('y'));
        $w = round($request->get('w'));
        $h = round($request->get('h'));

        $image = Image::make($request->get('theFile'));
        $mime = $image->mime();
        if($mime == 'image/jpeg'){
            $extension = '.jpg';
        }
        elseif ($mime == 'image/png'){
            $extension = '.png';
        }
        else{
            return false;
        }
        $image->crop($w, $h, $x, $y)->save(public_path('storage/profiles/'.$filename.$extension));
        $profile->photo = 'public/storage/profiles/'.$filename.$extension;
        $profile->save();
        return true;
    }
}
