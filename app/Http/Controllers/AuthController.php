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

	public function login(Request $request)
	{
		$this->validate($request, [
			'username' => 'required|email',
			'password' => 'required'
		]);
		$http = new \GuzzleHttp\Client();
		//$http = new GuzzleHttp\Client;

		try {
			//code...
			$response = $http->post(config('services.passport.login_endpoint'), [
				'form_params' => [
					'grant_type' => 'password',
					'client_id' => config('services.passport.client_id'),
					'client_secret' => config('services.passport.client_secret'),
					'username' => $request->username,
					'password' => $request->password,
				]
				]);

				//$response = $client->send($response);
				//return $response;
				//return $response->getBody()->getContents();
				return json_decode((string) $response->getBody(), true);
		} catch (\GuzzleHttp\Exception\BadResponseException $e) {
			
			if ($e->getCode() == 422) {
				
				return response()->json('Solicitação inválida, digite um nome de usuário', $e->getCode());
			} else if ($e->getCode() == 401) {
				# code...
				return response()->json('Nome de usuário ou senha inválidos. Tente novamente', $e->getCode());
			}
			return response()->json('Algo está errado no servidor,', $e->getCode());
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