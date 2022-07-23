<?php

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'namespace' => 'Auth', 'middleware' => ['cors'], 'as' => 'auth.'], static function (Router $router): void {
    $router->post('/register', 'AuthorizationController@register')->name('register');
    $router->post('/login', 'AuthorizationController@login')->name('login');
    $router->get('/verify', 'AuthorizationController@verify')->name('verify');
    $router->get('/resend/verify', 'AuthorizationController@verify')->name('resend_verify');

    $router->group(['prefix' => 'phone', 'namespace' => 'Phone', 'as' => 'phone.'], static function (Router $router): void {
        $router->post('/code', 'AuthorizationPhoneController@registerCode')->name('register_code');
        $router->put('/code', 'AuthorizationPhoneController@getAccount')->name('account');
        $router->post('/resend/code', 'AuthorizationPhoneController@resendCode')->name('resend_code');
    });
});

Route::group(['middleware' => ['cors', 'auth:api']], static function (Router $router): void {
    $router->controller('ProfileController')->group(static function (Router $router): void {
        $router->get('/profile', 'index');
        $router->post('/profile', 'update');
        $router->delete('/profile', 'destroy');
    });

    $router->apiResource('/profile', 'ProfileController');

    // $router->resource('/users', 'ApiController');
    $router->post('/chats/create', 'ChatController@create');
    $router->apiResource('/chats', 'ChatController', ['except' => 'update']);
    $router->post('/chats/{chat}', 'ChatController@update')->name('chats.update');

    $router->group(['namespace' => 'Message'], static function (Router $router): void {
        $router->put('/messages/seen', 'MessageSeeController');
    });
});

Route::group(['namespace' => 'Public'], static function (Router $router): void {
    $router->get('/countries', 'CountryController');
});

Route::post('/ping/ws', 'TestController@pingWs');

// Route::get('/chats', 'ChatController@chats');
// Route::get('/chats/{id}', 'ChatController');

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
