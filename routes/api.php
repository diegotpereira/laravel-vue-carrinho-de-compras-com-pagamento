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

});

Route::get('/ehAdmin', 'App\Http\Controllers\AuthController@ehAdmin');
Route::post('/AddNovoUsuario', 'App\Http\Controllers\AuthController@AddNovoUsuario');
Route::get('/TodosUsuarios', 'App\Http\Controllers\AuthController@index');
Route::put('/EditarUsuarios/{id}', 'App\Http\Controllers\AuthController@EditarUsuarios');
Route::delete('/DeletarUsuario/{id}', 'App\Http\Controllers\AuthController@DeletarUsuario');
Route::post('/logout', 'App\Http\Controllers\AuthController@logout');
Route::post('login', 'App\Http\Controllers\AuthController@login');
Route::post('registrar', 'App\Http\Controllers\AuthController@registrar');

Route::post('/addProduto', 'App\Http\Controllers\ProdutoController@addNovo');
Route::get('/produto', 'App\Http\Controllers\ProdutoController@index');
Route::put('/EditarProduto/{id}', 'App\Http\Controllers\ProdutoController@EditarProduto');
Route::delete('/DeletarProduto/{id}', 'App\Http\Controllers\ProdutoController@DeletarProduto');
Route::get('/getCarrinhoItens/{id}', 'App\Http\Controllers\ProdutoController@getCarrinhoItens');


    

//Route::post('/login', [
//	'uses' =>  'App\Http\Controllers\AuthController@login'
//]);



//Route::post('/registrar', [
//	'uses'=> 'App\Http\Controllers\AuthController@registrar'
//]);