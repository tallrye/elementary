<?php

namespace App\Http\Controllers\Profiles;

use Illuminate\Http\Request as Request;
use App\Http\Controllers\Controller;
use App\Profile;
use App\User;
use App\Models\Roles\Role;
use App\Models\Roles\RoleUser;
use App\Models\Notifications\Notification;
use App\UserServer;
use Datatables;
use File;
use Image;
use LaravelPusher;
use DB;

class MyProfileController extends Controller
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
     * Show user his/her own profile dashboard
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Profile $profile
     * @param   \App\Models\Notifications\Notification $myNotifications
     * @return  \Illuminate\Http\Response
     */
    public function myprofile(Request $request)
    {
        $myNotifications = Notification::where('user_id', \Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        $profile = Profile::find($request->user()->profile_id); 
        return view('profiles.myprofile.index', compact('profile', 'myNotifications'));
    }

    /**
     * Show user his/her own profile edit page
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Profile $profile
     * @return  \Illuminate\Http\Response
     */
    public function editmyprofile(Request $request)
    {
        $profile = Profile::find($request->user()->profile_id); 
        return view('profiles.myprofile.edit', compact('profile'));
    }

    /**
     * Update user's own profile
     * 
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Profile $profile
     * @param   \App\User $user
     * @param   \App\Models\Notifications\Notification
     * @param   \Illuminate\Session\Store flash()
     * @param   \LaravelPusher
     * @return  \Illuminate\Http\Response
     */
    public function updatemyprofile(Request $request)
    {
        $user = User::where('profile_id',$request->user()->profile_id)->first(); 
        $user->update($request->all());
        $profile = Profile::findOrFail($request->user()->profile_id); 
        $profile->update($request->all());
        session()->flash('success', 'Profil bilgileri güncellendi');
        foreach(usersWithRoleOf('superadmin') as $userByRole){
            createNotification($userByRole->user_id,3,1,$profile->name.' bilgilerini güncelledi.','Göz Atın','/profiles/admin/detail/'.$profile->id);
        }
        LaravelPusher::trigger('notifications-channel', 'refresh-notifications', ['message' => 'Bildirimlerinizi Kontrol Edin.']);
        return redirect()->back();
    }

    /**
     * Upload your profile picture
     *
     * @see   \App\Http\Controllers\Controller cropAndUploadProfilePhoto()
     * @return  \Illuminate\Http\Response
     */
    public function updatemyphoto(Request $request){
        if(parent::cropAndUploadProfilePhoto($request->user()->profile_id, $request)){
            session()->flash('success', 'Profil fotoğrafı güncellendi');
            return redirect()->back();
        }else{
            session()->flash('danger', 'Sadece .jpg ve .png formatlarında görsel yükleyebilirsiniz.');
            return redirect()->back();
        }
    }

}