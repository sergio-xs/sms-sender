<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/** Auth routes */
require __DIR__.'/auth.php';

/** Role management routes */
Route::group(['middleware' => 'auth'], function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    /** Management Routes*/
    Route::group(['namespace' => 'Management', 'as' => 'management.', 'middleware'=>'role_or_permission:administrator'], function () {
        /** Role Routes */
        Route::group(['as' => 'role.', 'prefix' => 'role'], function () {
           Route::post('datatable', 'RoleController@getForDatatable')->name('datatable');
        });
        Route::resource('role', 'RoleController');
        /** Permission Routes */
        Route::group(['as' => 'permission.', 'prefix' => 'permission'], function () {
            Route::post('datatable', 'PermissionController@getForDatatable')->name('datatable');
        });
        Route::resource('permission', 'PermissionController');
        /** User Routes */
        Route::group(['as' => 'user.', 'prefix' => 'user'], function (){
            Route::post('datatable', 'UserController@getForDatatable')->name('datatable');
            Route::post('gsm-box/{user}', 'UserController@setGsmBoxPermissions')->name('gsm-box');
        });
        Route::resource('user', 'UserController');
    });
});

