<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Route;

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

//Route::group(['prefix' => 'auth', 'as' => 'auth.'], function (): void {
//
//});

Route::group(['middleware' => 'auth:api'], static function (): void {
    Route::get('/profile', 'ProfileController');

    Route::apiResource('/profile', 'Api\ProfileController');

    // Route::get('/users', 'Api\UserController@index');
    Route::resource('/users', 'ApiController');
    Route::apiResource('/chats', 'Api\ChatController', ['except' => 'update']);
    Route::post('/chats/{chat}', 'Api\ChatController@update');
});

Route::post('/ping/ws', 'TestController@pingWs');

// Route::get('/chats', 'ChatController@chats');
// Route::get('/chats/{id}', 'ChatController');

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
