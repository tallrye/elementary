<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::auth();
Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{
	/* Home */
	Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
	// require(app_path() . '/routes/rolesAndPermissions.php');
	include('Routes\chat.php');
	include('Routes\profiles.php');
	include('Routes\rolesAndPermissions.php');
	include('Routes\notifications.php');

});