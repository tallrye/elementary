<?php

/* 
* All the routes under the "/profiles" for administration 
* as well as the user's own profile page
*/
Route::group(['prefix' => 'profiles', 'as' => 'profiles.', 'namespace' => 'Profiles'], function () {
    Route::get('/admin', ['as' => 'admin.index', 'uses' => 'ProfilesController@index']);
    Route::get('/admin/edit/{id}', ['as' => 'admin.edit', 'uses' => 'ProfilesController@edit']);
    Route::get('/admin/detail/{id}', ['as' => 'admin.detail', 'uses' => 'ProfilesController@detail']);
    Route::get('/admin/create', ['as' => 'admin.create', 'uses' => 'ProfilesController@create']);
    Route::post('/admin/update', ['as' => 'admin.update', 'uses' => 'ProfilesController@update']);
    Route::post('/admin/updatephoto', ['as' => 'admin.updatephoto', 'uses' => 'ProfilesController@updatephoto']);
    Route::post('/admin/store', ['as' => 'admin.store', 'uses' => 'ProfilesController@store']);
    Route::post('/admin/sendlink', ['as' => 'admin.sendlink', 'uses' => 'ProfilesController@sendlink']);
    Route::post('/admin/block', ['as' => 'admin.block', 'uses' => 'ProfilesController@block']);
    Route::post('/admin/unblock', ['as' => 'admin.unblock', 'uses' => 'ProfilesController@unblock']);
    Route::post('/admin/addip', ['as' => 'admin.addip', 'uses' => 'ProfilesController@addip']);
    Route::post('/admin/removeip', ['as' => 'admin.removeip', 'uses' => 'ProfilesController@removeip']);
    Route::post('/admin/addrole', ['as' => 'admin.addrole', 'uses' => 'ProfilesController@addrole']);
    Route::post('/admin/delete', ['as' => 'admin.delete', 'uses' => 'ProfilesController@delete']);
    Route::get('/admin/load', ['as' => 'admin.load', 'uses' => 'ProfilesController@load']);
    Route::get('/admin/fetch/{id}', ['as' => 'admin.fetch', 'uses' => 'ProfilesController@fetch']);
    Route::get('/admin/search/{id}', ['as' => 'admin.search', 'uses' => 'ProfilesController@search']);
    Route::get('/myprofile', ['as' => 'myprofile', 'uses' => 'MyProfileController@myprofile']);
    Route::get('/myprofile/edit', ['as' => 'myprofile.edit', 'uses' => 'MyProfileController@editmyprofile']);
    Route::post('/myprofile/update', ['as' => 'myprofile.update', 'uses' => 'MyProfileController@updatemyprofile']);
    Route::post('/myprofile/updatemyphoto', ['as' => 'myprofile.updatemyphoto', 'uses' => 'MyProfileController@updatemyphoto']);
});