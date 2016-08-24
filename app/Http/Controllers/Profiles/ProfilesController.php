<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Auth;
use App\Profile;
use App\User;
use App\Models\Roles\Role;
use App\Models\Roles\RoleUser;
use App\Models\Notifications\Notification;
use App\UserServer;
use Datatables;
use File;
use LaravelPusher;
use DB;

class ProfilesController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | All Users and Profiles Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles all the users in the application
    | including viewing/updating profiles, sending activation links, 
    | blocking and unblocking users etc. By default, architect user can not
    | be managed other than the sys architect himself.
    |
    */

    /**
     * Constructor method defines accessibility permissions
     *
     * @param   \Illuminate\Support\Facades\Auth
     * @return  \Illuminate\Foundation\Application abort
     */
    public function __construct() {
        parent::__construct();
        parent::checkPermission('manage_users');
    }

    /**
     * Show the listing page of all users.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profiles.index');
    }

    /**
     * Live Ajax load of the users into Datatable.
     *
     * @param   \Yajra\Datatables\DatatablesServiceProvider
     * @param   \App\Profile 
     * @return  \Illuminate\Http\Response
     */
    public function load()
    {
        return Datatables::of(Profile::select('*'))->make(true);
    }

    /**
     * Live Ajax fetch for a single user.
     *
     * @param   integer $id
     * @param   \App\Profile 
     * @return  \Illuminate\Http\Response
     */
    public function fetch($id)
    {
        return Profile::findOrFail($id);
    }

    /**
     * Show the page for creating new user.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profiles.create');
    }
    
    /**
     * Show the edit page of a profile.
     *
     * @param   integer $id
     * @param   \App\Profile $profile
     * @param   \App\Roles\Role 
     * @param   \Illuminate\Auth\AuthServiceProvider
     * @return  \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = Profile::findOrFail($id);
        if($profile->user && count($profile->user->roles) > 0 && $profile->user->roles[0]->id == 1 && \Auth::user()->id != $profile->user->id){
            abort('403');
        }
        $roles = Role::where('id', '!=', 1)->get();
        return view('profiles.edit', compact('profile', 'roles'));
    }

    /**
     * Show the detail page of a profile.,*
     *
     * @param   integer $id
     * @param   \App\Profile $profile
     * @return  \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $profile = Profile::findOrFail($id);
        return view('profiles.detail', compact('profile'));
    }

    /**
     * Store a new profile.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Profile 
     * @param   \Illuminate\Session\Store flash()
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Profile::$rules);
        Profile::create($request->all());
        session()->flash('success', 'Yeni Profil Oluşturuldu.');
        return redirect()->route('profiles.admin.index');
    }

    /**
     * Send an activation link to a user for registration.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Profile $profile
     * @param   \Illuminate\Mail\MailServiceProvider
     * @param   \Illuminate\Support\Facades\Config
     * @param   \Illuminate\Session\Store flash()
     * @return  \Illuminate\Http\Response
     */
    public function sendlink(Request $request)
    {
        $profile = Profile::findOrFail($request->get('id'));
        $profile->update(['isActivationSent' => true]);
        $link = url('register?name='.$profile->name.'&email='.$profile->email.'&profile='.$profile->id.'', $parameters = [], $secure = null);
        \Mail::send('auth.emails.registiration', ['name' => $profile->name, 'email' => $profile->email, 'link' => $link], function ($m) use($profile) {
            $m->to($profile->email, $profile->name);
            $m->subject(config('project.name') . ' Aktivasyonu');
        });
        session()->flash('success', 'Aktivasyon Linki Gönderildi.');
        return redirect()->back();
    }

    /**
     * Update existing profile.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Profile $profile
     * @param   \App\User $user
     * @param   \Illuminate\Session\Store flash()
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, ['name' => 'required', 'email' => 'required']);
        $profile = Profile::findOrFail($request->get('id'));
        $profile->update($request->all());
        $user = User::where('profile_id',$request->get('id'))->first();
        if($user){
            $user->update($request->all());
        }
        session()->flash('success', 'Profil Güncellendi');
        return redirect()->back();
    }

    /**
     * Block a user's accessibility.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Profile $profile
     * @param   \Illuminate\Session\Store flash()
     * @return  \Illuminate\Http\Response
     */
    public function block(Request $request)
    {
        $profile = Profile::findOrFail($request->get('id'));
        $profile->update(['isBlocked' => true]);
        session()->flash('success', 'Kullanıcı bloke edildi.');
        return redirect()->back();
    }

    /**
     * Block a user's accessibility.
     *
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Profile $profile
     * @param   \Illuminate\Session\Store flash()
     * @return  \Illuminate\Http\Response
     */
    public function unblock(Request $request)
    {
        $profile = Profile::findOrFail($request->get('id'));
        $profile->update(['isBlocked' => false]);
        session()->flash('success', 'Kullanıcı blokesi kaldırıldı.');
        return redirect()->back();
    }

    /**
     * Add new IP address to user
     *
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\UserServer
     * @param   \Illuminate\Session\Store flash()
     * @return  \Illuminate\Http\Response
     */
    public function addip(Request $request)
    {
        $this->validate($request, UserServer::$rules);
        UserServer::create($request->all());
        session()->flash('success', 'Yeni IP Adresi Eklendi.');
        return redirect()->back();
    }

    /**
     * Remove an IP address from user,
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\UserServer
     * @param   \Illuminate\Session\Store flash()
     * @return  \Illuminate\Http\Response
     */
    public function removeip(Request $request)
    {
        $server = UserServer::findOrFail($request->get('id'));
        $server->delete();
        session()->flash('success', 'IP Adresi Kaldırıldı.');
        return redirect()->back();
    }

    /**
     * Add new role to a user after removing existing role
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\User $user 
     * @param   \App\Roles\RoleUser $newRole
     * @param   \Illuminate\Session\Store flash()
     * @return  \Illuminate\Http\Response
     */
    public function addrole(Request $request)
    {
        $this->validate($request, RoleUser::$rules);
        $user = User::findOrFail($request->get('user_id'));
        if(count($user->roles)){
            $user->roles()->detach();
        }
        RoleUser::create($request->all());
        session()->flash('success', 'Kullanıcıya Yeni Rol Tanımlandı.');
        return redirect()->back();
    }

    /**
     * Upload a new profile picture for a user
     *
     * @see     \App\Http\Controllers\Controller cropAndUploadProfilePhoto()
     * @return  \Illuminate\Http\Response
     */
    public function updatephoto(Request $request){
        if(cropAndUploadProfilePhoto($request->get('id'), $request)){
            session()->flash('success', 'Profil fotoğrafı güncellendi');
            return redirect()->back();
        }
        session()->flash('danger', 'Sadece .jpg ve .png formatlarında görsel yükleyebilirsiniz.');
        return redirect()->back();
    }

    /**
     * Delete existing profile along with the user info in the System.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \DB
     * @param   \App\Profile $profile
     * @param   \App\UserServer $userServers
     * @param   \App\User $user
     * @param   \LaravelPusher
     * @return  string
     */
    public function delete(Request $request)
    {
        if($request->get('id') == 1){
            LaravelPusher::trigger('profiles-channel', 'refresh-profiles', ['message' => 'Bu Kullanıcı Silinemez']);
            return 'Bu Kullanıcı Silinemez';
        }
        $user = User::where('profile_id',$request->get('id'))->first();
        DB::table('role_user')->where('user_id', '=', $user->id)->delete();
        User::destroy($user->id);
        $userServers = UserServer::where('profile_id',$request->get('id'))->get();
        foreach($userServers as $server){
            $server->delete();
        }
        Profile::destroy($request->get('id'));
        LaravelPusher::trigger('profiles-channel', 'refresh-profiles', ['message' => 'Kullanıcı Kaldırıldı']);
        return 'Kullanıcı Kaldırıldı';
    }


}