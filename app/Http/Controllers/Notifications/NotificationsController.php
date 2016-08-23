<?php

namespace App\Http\Controllers\Notifications;

use Illuminate\Http\Request as Request;
use App\Http\Controllers\Controller;
use App\Profile;
use App\Models\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Datatables;
use File;
use Image;
use LaravelPusher;
use DB;

class NotificationsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Authenticated User's Self Profile Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the user's self profile pages
    | including viewing/updating his/her own profile.
    |
    */


    /**
     * Constructor method inherits directly from it's parent
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Get most recent notifications via Ajax
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Models\Notification\Notification $notification
     * @return  string
     */
    public function get(Request $request)
    {
        $notifications = Notification::where('user_id', $request->get('user_id'))->where('isRead', 'false')->with('type')->get();
        return $notifications;
    }

    /**
     * Change notification status to "read" via Ajax
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Models\Notification\Notification $notification
     * @return  string
     */
    public function read(Request $request)
    {
        $notification = Notification::findOrFail($request->get('id'));
        $notification->isRead = true;
        $notification->save();
        $unread = Notification::where('user_id', Auth::user()->id)->where('isRead', 'false')->count();
        return $unread;
    }

    

}