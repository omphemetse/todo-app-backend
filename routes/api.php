<?php

use Illuminate\Http\Request;
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
Route::group(['prefix' => 'v1'], function () {

    //public routes
    Route::post('/login', 'Api\AuthController@login')->name('login.api');
    Route::post('/register', 'Api\AuthController@register')->name('register.api');

    //private routes
    Route::middleware('auth:api')->group(function () {
        Route::get('/tasks', 'Api\TaskController@index')->name('api.tasks');
        Route::post('/tasks/new', 'Api\TaskController@store')->name('api.tasks.new');
        Route::delete('/tasks/{id}', 'Api\TaskController@destroy')->name('api.tasks.delete');
        Route::put('/tasks/{id}', 'Api\TaskController@update')->name('api.tasks.update');
    });
});
