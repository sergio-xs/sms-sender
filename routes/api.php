<?php

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

/** Login route through api */
Route::post('/auth/login', 'AuthController@loginUser');

/** Routes for sending sms through different providers */
Route::group(['as' => 'send-sms.', 'prefix' => 'send-sms', 'middleware' => ['auth:sanctum']], function () {

    /** Send sms with tokyDigital provider route */
    Route::group(['middleware' => ['ability:tokyDigital']], function () {
        Route::post('/toky-digital', 'SmsSendController@sendTokyDigital')->name('toky-digital');
    });

    /** Send sms with gsmbox provider route */
    Route::group(['middleware' => ['gsm-permission']], function () {
        Route::post('/gsm-box', 'SmsSendController@sendGsmBox')->name('gsm-box');
    });

});
