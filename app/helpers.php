<?php

use App\User;
use App\Models\Roles\Role;
use App\Models\Roles\RoleUser;
use App\Models\Notifications\Notification;
use App\Models\Chat\Conversation;
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
	if($user){
		return true;
	}
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
	$roleUsers = RoleUser::where('role_id', $role->id)->get();
	return $roleUsers;
}

/**
 * Get every user for a given role
 *
 * @param   integer  $user
 * @param   integer  $type
 * @param   integer  $importance
 * @param   string   $description
 * @param   string   $actName
 * @param   string   $actLink
 * @param   \App\Models\Notifications\Notification
 * @return  void
 */
function createNotification($user, $type, $importance, $description, $actName, $actLink){
	Notification::create([
        'user_id' => $user,
        'notificationType_id' => $type,
        'importance' => $importance,
        'description' => $description, 
        'action_name' => $actName,
        'action_link' => $actLink
    ]);
}

/**
 * Get every user for a given role
 *
 * @param   integer  $user
 * @param   \App\Models\Chat\Conversation
 * @return  boolean
 */
function doIHaveConversationWith($user){
	$conversation = App\Models\Chat\Conversation::where('sender_id', Auth::user()->id)->where('recipient_id', $user)->first();
	if($conversation){return true;}
	return false;
}

/**
 * Get every user for a given role
 *
 * @param   integer  $user
 * @param   \App\Models\Chat\Conversation
 * @return  array
 */
function myConversationWith($user){
	return App\Models\Chat\Conversation::where('sender_id', Auth::user()->id)->where('recipient_id', $user)->first();
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
