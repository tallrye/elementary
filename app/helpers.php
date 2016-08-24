<?php

use App\User;
use App\Profile;
use App\Models\Roles\Role;
use App\Models\Roles\RoleUser;
use App\Models\Chat\Message;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Globally Accessible Helper Methods
|--------------------------------------------------------------------------
|
| These methods are made to use throughout the application
| in order to minimize repeating calculations.
| Most of these methods accepts a @param and returns a variable,
| a collection, or a boolean.
|
*/

    
/**
 * Check to see if a given profile has a user credentials.
 *
 * @param   integer  $profile
 * @param   \App\User $user
 * @return  boolean
 */
function hasUser($profile){
	$user = User::where('profile_id', $profile)->first();
	if($user){return true;}
	return false;
}


/**
 * Get every user for a given role
 *
 * @param   string  $role
 * @param   \App\Models\Roles\Role $role
 * @param   \App\Models\Roles\RoleUser $roleUsers
 * @return  array
 */
function usersWithRoleOf($name){
	$role = Role::where('name', $name)->first();
	return RoleUser::where('role_id', $role->id)->get();
}


/**
 * Get the count of unread messages sent by a certain user
 *
 * @param   integer  $user
 * @param   \App\Models\Chat\Message
 * @return  array
 */
function myMessageCountFrom($user){
	return Message::where('sender_id', $user)->where('recipient_id', Auth::user()->id)->where('isRead', 'false')->count();
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
function cropAndUploadProfilePhoto($profile, $request){
    $image = Image::make($request->get('theFile'));
    if($image->mime() == 'image/jpeg' || $image->mime() == 'image/png'){
	    $profile = Profile::find($profile);
	    $filename = time().'userprofile'.$profile->id;

	    if($profile->photo != 'public/assets/team.png'){
	        File::delete($profile->photo);
	    }

	    $x = round($request->get('x'));
	    $y = round($request->get('y'));
	    $w = round($request->get('w'));
	    $h = round($request->get('h'));

	    $extension = ($image->mime() == 'image/png') ? '.png' : '.jpg';
	    
	    $image->crop($w, $h, $x, $y)->save(public_path('storage/profiles/'.$filename.$extension));
	    $profile->photo = 'public/storage/profiles/'.$filename.$extension;
	    $profile->save();
	    return true;
    }
    return false;
}