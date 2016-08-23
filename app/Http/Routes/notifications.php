<?php 

/* 
* All the routes under the "/notifications" for user interface 
*/
Route::group(['prefix' => 'notifications', 'as' => 'notifications.', 'namespace' => 'Notifications'], function () {
    Route::get('/', ['as' => 'admin.index', 'uses' => 'NotificationsController@index']);
    Route::post('/read', ['as' => 'admin.read', 'uses' => 'NotificationsController@read']);
    Route::post('/get', ['as' => 'admin.get', 'uses' => 'NotificationsController@get']);
});