<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Facades\Hash;

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

public function registrar(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]); 
        $user = User::create([
            'name' => $request->input('name'),
	          'email' => $request->input('email'),
	          'password' => bcrypt($request->input('password'))
        ]);
       
        $token = $user->createToken('LaravelAuthApp')->accessToken;
 
        return response()->json(['token' => $token], 200);
    }

	//public function login(Request $request)
    //{
    //    $data = [
    //        'email' => $request->username,
    //        'password' => $request->password
    //    ];
 
		
    //    if (auth()->attempt($data)) {
    //        $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
    //        return response()->json(['token' => $token], 200);
    //    } else {
    //        return response()->json(['error' => 'Unauthorised'], 401);
    //    }
    //} 

//	public function login(Request $request)
//{
//      $this->validate($request,[
//           'username' => 'required|email',
//           'password' => 'required'
//      ]);

//     $http = new \GuzzleHttp\Client();

//      try {

//		$response = $http->post(config('services.passport.login_endpoint'),[ 
//			'form_params' => [
//			   'grant_type' => 'password',
//			   'client_id' => config('services.passport.client_id'),
//			   'client_secret' => config('services.passport.client_secret'),
//				'username' => $request->username,
//				'password' => $request->password,
//			]
//		 ]);

//		$headers = [
//			'Content-Type' => 'application/x-www-form-urlencoded|',
//			'Accept'=>'application/json',
				  
//			  ];

//			  $client_post = new \GuzzleHttp\Client([
//				'headers' => $headers
//			]);

//			$r =  $client_post->request('POST', $http, [
//				'form_params' => $response
//			]);
//			$response = $r->getBody()->getContents();
//			$response = json_decode($response,true);

//      } catch(\GuzzleHttp\Exception\BadResponseException $e){
//      	if ($e->getCode() == 422) {

//      	  return response()->json('Invalid Request, plese enter a username', $e->getCode());
//      	}
//      	else if ($e->getCode() == 401) {
      		
//      		return response()->json('Invalid username Or password.try again', $e->getCode());
//      	}

//      	return response()->json('Something want wrrong ont the server,', $e->getCode());
//      }
//	}

public function login (Request $request) {
	$validator = Validator::make($request->all(), [
		'username' => 'required|string|email|max:255',
		'password' => 'required|string|min:6|confirmed',
	]);
	if ($validator->fails())
	{
		return response(['errors'=>$validator->errors()->all()], 422);
	}
	$user = User::where('email', $request->email)->first();
	if ($user) {
		if (Hash::check($request->password, $user->password)) {
			$token = $user->createToken('Laravel Password Grant Client')->accessToken;
			$response = ['token' => $token];
			return response($response, 200);
		} else {
			$response = ["message" => "Password mismatch"];
			return response($response, 422);
		}
	} else {
		$response = ["message" =>'User does not exist'];
		return response($response, 422);
	}
}

//public function login(Request $request)
//    {   
//      $http =new \GuzzleHttp\Client;
//      try{
//        $respone=$http->post(config('services.passport.login_endpoint'),[
//          'form_params'=>[
//            'grant_type'=>'password',
//            'client_id'=>config('services.passport.client_id'),

 
//            'client_secret'=>config('services.passport.client_secret'),
//            'username'=>$request->username,
//            'password'=>$request->password,
//          ],
//          'http_errors' => false
//        ]);               
//        return $respone->getBody();
//      }
   
//      catch(\GuzzleHttp\Exception\BadResponeException $e){     
//        if ($e->getcode()==400){
//          return response()->json('Invalid Request. Please enter a username or a password.',$e->getcode());
//        }else if ($e->getcode()==401){
//          return response()->json('Your credentials are incorrect. PLease try again.',$e->getcode());
//        }
//        return response()->json('Something went wrong on the server.',$e->getcode());

 
//      }

//    }

	//public function login(Request $request)
    //{
	//	$this->validate($request,[
	//		'username' => 'required|email',
	//		'password' => 'required'
	//   ]);
    //    //$email = $request->username;
    //    //$password = $request->password;

    //    //// Check if field is not empty
    //    //if (empty($email) or empty($password)) {
    //    //    return response()->json(['status' => 'error', 'message' => 'You must fill all fields']);
    //    //}

    //    $client = new Client();

    //    try {
    //        $response = $client->request('POST', env('APP_URL').'/oauth/token', [
    //            "form_params" => [
    //                "client_secret" => 'BWLuNKeUJZJF6tTB7T20y4Ctk7I5U2OZxxCB8Ejs',
    //                "grant_type" => "password",
    //                "client_id" => '3',
    //                'username' => $request->username,
    //                "password" => $request->password
    //            ]
    //        ]);
    //    } catch (BadResponseException $e) {
    //        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    //    }
    //}

	public function logout() 
	{
		auth()->user()->tokens->each(function($token, $key) {
			$token->delete();
		});
		return response()->json('Desconectado com sucesso', 200);
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
	public function EditarUsuarios(Request $request, $id)
	{
		$user = User::find($id);

		if (file_exists(public_path().'/produtoImagens/'.$request->imagePath) AND $user->imagePath !== null) {
			$user->imagePath = $request->input('imagePath');
			$user->name = $request->input('name');
			$user->role_id = $request->input('role_id');
			$user->email = $request->input('email');
			$user->password = bcrypt($request->input('password'));
		} else if (file_exists(public_path().'/produtoImagens/'.$request->imagePath) AND $user->imagePath == null) {
			$user->imagePath = null;
			$user->name = $request->input('name');
			$user->role_id = $request->input('role_id');
			$user->email = $request->input('email');
			$user->password = bcrypt($request->input('password'));
		} else if (!file_exists(public_path().'/produtoImagens/'.$request->imagePath) AND $user->imagePath == null) {
			$exploded = explode(',', $request->imagePath);
			$decoded = base64_decode($exploded[1]);

			if (str_contains($exploded[0], 'jpeg')) {
				$extension = 'jpeg';
			} else {
				$extension =  'png';
			}
			$arquivoNome = str::random().'.'.$extension;
			$path = public_path().'/produtoImagens/'.$arquivoNome;
			file_put_contents($path, $decoded);

			$user->imagePath = $arquivoNome;
			$user->name = $request->input('name');
			$user->role_Id = $request->input('role_id');
			$user->email = $request->input('email');
			$user->password = bcrypt($request->input('password'));
		} else {
			unlink(public_path().'/produtoImagens/'.$user->imagePath);
			$exploded = explode(',', $request->imagePath);
			$decoded = base64_decode($exploded[1]);

			if (str_contains($exploded[0], 'jpeg')) {
				$extension = 'jpeg';
			} else {
				$extension = 'png';
			}
			$arquivoNome = str::random().'.'.$extension;
			$path = public_path().'/produtoImagens/'.$arquivoNome;
			file_put_contents($path, $decoded);

			$user->imagePath = $arquivoNome;
			$user->name = $request->input('name');
			$user->role_id = $request->input('role_id');
			$user->email = $request->input('email');
			$user->password = bcrypt($request->input('password'));
		}
		$user->save();

		return response()->json(['user' => $user], 200);
	}
	public function AddNovoUsuario(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => 'required'
		]);
		$input = $request->all();

		$exploded = explode(',', $request->imagePath);
		$decoded = base64_decode($exploded[1]);

		if (str_contains($exploded[0], 'jpeg')) {
			$extension = 'jpeg';
		} else {
			$extension = 'png';
		}
		$arquivoNome = str::random().'.'.$extension;
		$path = public_path().'/produtoImagens/'.$arquivoNome;
		file_put_contents($path, $decoded);

		$user = new User([
			'imagePath' => $arquivoNome,
			'name' => $request->input('name'),
			'roel_id' => $request->input('role_id'),
			'email' => $request->input('email'),
			'password' => bcrypt($request->input('password'))
		]);
		$user->save();

		return response()->json(['user' => $user], 201);
	}
	public function DeletarUsuario($id)
	{
		$user = USer::find($id);

		if ($user->imagePath !== null) {
			unlink(public_path().'/produtoImagens/'.$user->imagePath);
		}
		$user->delete();

		return response()->json(['message' => 'usuario deletado', 200]);
	}
}
