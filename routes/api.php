<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
	Route::get('/ehAdmin', 'App\Http\Controllers\AuthController@isAdmin');
});

Route::post('/entrar', [
	'uses' =>  'App\Http\Controllers\AuthController@entrar'
]);

Route::post('/registrar', [
	'uses'=> 'App\Http\Controllers\AuthController@registrar'
]);