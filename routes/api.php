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

Route::post('push-client-update', 'PusherController@pushInputPaneltUpdate');
Route::post('start-session', 'PusherController@startSession');
Route::post('update-session', 'PusherController@receiveSesionUpdate');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
