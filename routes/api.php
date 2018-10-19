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
Route::get('corcern/unset/{token}/{target_id}', "API\MatchController@removeConcern");

Route::get('consult/get_list', 'MessageController@index');
Route::get('concern/get_list', 'MessageController@get_concern_list');
Route::post('messages/send', 'MessageController@send');
Route::post('consult/request', "API\MatchController@request_consult");
Route::post('consult/accept', "API\MatchController@accept_consult");