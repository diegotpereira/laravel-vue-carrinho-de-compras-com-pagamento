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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
	Route::get('/ehAdmin', 'App\Http\Controllers\AuthController@ehAdmin');
	Route::get('/produto', 'App\Http\Controllers\ProdutoController@index');
	Route::post('/AddProduto', 'App\Http\Controllers\ProdutoController@AddNovo');
	Route::post('/logout', 'App\Http\Controllers\AuthController@logout');
});


    

Route::post('/login', [
	'uses' =>  'App\Http\Controllers\AuthController@login'
]);

Route::post('/registrar', [
	'uses'=> 'App\Http\Controllers\AuthController@registrar'
]);