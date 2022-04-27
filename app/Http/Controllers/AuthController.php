<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

	public function registrar(Request $request) 
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => 'required'
		]);
		$user = new User([
			'name' => $request->input('name'),
			'email' => $request->input('email'),
			'password' => bcrypt($request->input('password'))
		]);
		$user->save();

		Auth::entrar($user);

		return response()->json([
			'message' => 'Usuário Criado com Sucesso'
		], 201);
	}
}