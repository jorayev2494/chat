<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
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

Route::group(['prefix' => 'auth', 'middleware' => ['api'], 'namespace' => 'Auth'], static function (Router $router): void {
    $router->post('/register', 'AuthorizationController@register');
    $router->post('/login', 'AuthorizationController@login');

    $router->group(['prefix' => 'phone', 'namespace' => 'Phone'], static function (Router $router): void {
        $router->post('/code', 'AuthorizationPhoneController@registerCode');
        $router->put('/code', 'AuthorizationPhoneController@getAccount');
        // $router->post('/login', 'AuthorizationPhoneController@login');
    });
});

Route::group(['middleware' => 'auth:api'], static function (Router $router): void {
    $router->controller('ProfileController')->group(static function (Router $router): void {
        $router->get('/profile', 'index');
        $router->post('/profile', 'update');
        $router->delete('/profile', 'destroy');
    });


//     Route::apiResource('/profile', 'ProfileController');

//     // Route::get('/users', 'Api\UserController@index');
//     Route::resource('/users', 'ApiController');
//     Route::apiResource('/chats', 'Api\ChatController', ['except' => 'update']);
//     Route::post('/chats/{chat}', ['uses' => 'Api\ChatController@update', 'as' => 'chats.update']);
});

Route::post('/ping/ws', 'TestController@pingWs');

// Route::get('/chats', 'ChatController@chats');
// Route::get('/chats/{id}', 'ChatController');

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
