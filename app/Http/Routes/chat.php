<?php 

/* 
* All the routes used for side messages
*/
Route::group(['prefix' => 'chat', 'as' => 'chat.', 'namespace' => 'Chats'], function () {
    Route::post('/openthread', ['as' => 'openthread', 'uses' => 'ChatsController@openthread']);
	Route::post('/sendmessage', ['as' => 'sendmessage', 'uses' => 'ChatsController@sendmessage']);
	Route::post('/loadearlier', ['as' => 'loadearlier', 'uses' => 'ChatsController@loadearlier']);
	Route::get('/fetchmessage/{id}', ['as' => 'fetchmessage', 'uses' => 'ChatsController@fetchmessage']);
	Route::get('/newmessage/{id}', ['as' => 'newmessage', 'uses' => 'ChatsController@newmessage']);
	Route::get('/loadconversationwith/{id}', ['as' => 'loadconversationwith', 'uses' => 'ChatsController@loadconversationwith']);
	Route::post('/read/{id}', ['as' => 'readmessage', 'uses' => 'ChatsController@readmessage']);
});