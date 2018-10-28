<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/user/login', 'API\UserController@login');
Route::post('/user/register', 'API\UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
  Route::post('details', 'API\UserController@details');
});
Route::get('user/edit/{user_id}', 'API\UserController@edit');
Route::post('user/edit', 'API\UserController@update');

Route::get('user/get_list/{token}',"API\MatchController@getList");
Route::post('score/set', "API\MatchController@setScore");
Route::post('concern/set', "API\MatchController@setConcern");
Route::post('concern/unset', "API\MatchController@removeConcern");

Route::get('consult/get_list', 'MessageController@index');
Route::get('concern/get_list', 'MessageController@get_concern_list');
Route::post('messages/send', 'MessageController@send');
Route::post('consult/request', "API\MatchController@request_consult");
Route::post('consult/accept_request', "API\MatchController@accept_consult");
Route::post('consult/reject_request', "API\MatchController@reject_consult");
Route::GET('messages/get_message', 'MessageController@get_message');
Route::GET('messages/get_individual_message', 'MessageController@get_individual_message');
Route::post('user/update_signal_id', "API\MatchController@update_signal_id");
Route::post('assets/upload_photo', 'API\MatchController@upload');
Route::post('user/login_with_facebook', "API\UserController@get_user_with_face");