<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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

	//public function login(Request $request)
    //{
    //    $data = [
    //        'email' => $request->email,
    //        'password' => $request->password
    //    ];
 
    //    if (auth()->attempt($data)) {
    //        $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
    //        return response()->json(['token' => $token], 200);
    //    } else {
    //        return response()->json(['error' => 'Unauthorised'], 401);
    //    }
    //} 
	//public function login (Request $request) {


	//	$validator = Validator::make($request->all(), [
	//		'username' => 'required|email',
	//		'password' => 'required'
	//	]);
	//	if ($validator->fails())
	//	{
	//		return response(['errors'=>$validator->errors()->all()], 422);
	//	}
	//	$user = User::where('email', $request->email)->first();
	//	if ($user) {
	//		if (Hash::check($request->password, $user->password)) {
	//			$token = $user->createToken('Laravel Password Grant Client')->accessToken;
	//			$response = ['token' => $token];
	//			return response($response, 200);
	//		} else {
	//			$response = ["message" => "Password mismatch"];
	//			return response($response, 422);
	//		}
	//	} else {
	//		$response = ["message" =>'User does not exist'];
	//		return response($response, 422);
	//	}
	//}

	//public function login(Request $request)
	//{
	//	$this->validate($request, [
	//		'username' => 'required|email',
	//		'password' => 'required'
	//	]);
	//	$http = new \GuzzleHttp\Client();
	//	//$http = new GuzzleHttp\Client;

	//	try {
	//		//code...
	//		$response = $http->post(config('services.passport.login_endpoint'), [
	//			'form_params' => [
	//				'grant_type' => 'password',
	//				'client_id' => '1',
	//				'client_secret' => 'mZLUT3cmSMAlkvNFhGkhq71cYlEZITGEwIYvjIKi',
	//				'username' => 'teste@gmail.com',
	//				'password' => 'irg@9351982',
	//			]
	//			]);

	//			//$response = $client->send($response);
	//			//return $response;
	//			//return $response->getBody()->getContents();
	//			return json_decode((string) $response->getBody(), true);
	//	} catch (\GuzzleHttp\Exception\BadResponseException $e) {
			
	//		if ($e->getCode() == 422) {
				
	//			return response()->json('Solicitação inválida, digite um nome de usuário', $e->getCode());
	//		} else if ($e->getCode() == 401) {
	//			# code...
	//			return response()->json('Nome de usuário ou senha inválidos. Tente novamente', $e->getCode());
	//		}
	//		return response()->json('Algo está errado no servidor,', $e->getCode());
	//	}
	//}

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