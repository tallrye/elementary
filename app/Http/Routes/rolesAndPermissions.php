<?php 

/* 
* All the routes under the "/roles" for administration 
*/
Route::group(['prefix' => 'roles', 'as' => 'roles.', 'namespace' => 'Auth'], function () {
    Route::get('/', ['as' => 'index', 'uses' => 'RolesController@index']);
	Route::get('/load', ['as' => 'load', 'uses' => 'RolesController@load']);
	Route::get('/fetch/{id}', ['as' => 'fetch', 'uses' => 'RolesController@fetch']);
	Route::get('/search/{id}', ['as' => 'search', 'uses' => 'RolesController@search']);
	Route::get('/create', ['as' => 'create', 'uses' => 'RolesController@create']);
	Route::post('/store', ['as' => 'store', 'uses' => 'RolesController@store']);
	Route::get('/edit/{id}', ['as' => 'edit', 'uses' => 'RolesController@edit']);
	Route::post('/update', ['as' => 'update', 'uses' => 'RolesController@update']);
	Route::post('/delete', ['as' => 'delete', 'uses' => 'RolesController@delete']);
	Route::post('/addpermission', ['as' => 'addpermission', 'uses' => 'RolesController@addpermission']);
	Route::post('/removepermission', ['as' => 'removepermission', 'uses' => 'RolesController@removepermission']);
});

/* 
* All the routes under the "/permissions" for administration 
*/
Route::group(['prefix' => 'permissions', 'as' => 'permissions.', 'namespace' => 'Auth'], function () {
	Route::get('/', ['as' => 'index', 'uses' => 'PermissionsController@index']);
	Route::get('/load', ['as' => 'load', 'uses' => 'PermissionsController@load']);
	Route::get('/fetch/{id}', ['as' => 'fetch', 'uses' => 'PermissionsController@fetch']);
	Route::post('/store', ['as' =>'store', 'uses' => 'PermissionsController@store']);
	Route::post('/update', ['as' => 'update', 'uses' => 'PermissionsController@update']);
	Route::post('/delete', ['as' => 'delete', 'uses' => 'PermissionsController@delete']);
	Route::get('/search/{id}', ['as' => 'search', 'uses' => 'PermissionsController@search']);
});