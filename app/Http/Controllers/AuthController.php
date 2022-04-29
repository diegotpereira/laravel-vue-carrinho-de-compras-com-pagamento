<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function index()
	{
		$users = User::all();

		$response = [
			'users' => $users
		];
		return response()->json($response, 200);
	}

	public function login(){

		$login_credentials=[
            'email' => 'teste@gmail.com',
           'password' => 'irg@9351982'
        ];

        if(auth()->attempt($login_credentials)){
			$user_login_token= auth()->user()->createToken('PassportExample@Section.io')->accessToken;

			return response()->json(['token' => $user_login_token], 200);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

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

		Auth::login($user);

		return response()->json([
			'message' => 'Usuário Criado com Sucesso'
		], 201);
	}
	public function ehAdmin(Request $request)
	{
		$id = $request->user()->id;

		$user = User::find($id);

		$role = $user->role_id;

		if ($role == 1) {
			# code...

			return response()->json(["role" => true], 200);
		} else {
			return response()->json(["role" => null], 200);
		}
	}
}
