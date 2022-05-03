<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Laravel\Passport\Client as OClient;
use Laravel\Passport;
use Illuminate\Support\Str;

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

	//public function login(){



	//	$login_credentials=[
    //        'email' => 'teste@gmail.com',
    //       'password' => 'irg@9351982'
    //    ];



    //    if(auth()->attempt($login_credentials)){
	//		$user_login_token= auth()->user()->createToken('Laravel Password Grant Client')->accessToken;

		

	//		return response()->json(['token' => $user_login_token], 200);
    //    }
    //    else{
    //        return response()->json(['error'=>'Unauthorised'], 401);
    //    }
    //}

	//public function registrar(Request $request) 
	//{
	//	$this->validate($request, [
	//		'username' => 'required',
	//		'email' => 'required|email|unique:users',
	//		'password' => 'required'
	//	]);
	//	$user = new User([
	//		'name' => $request->input('username'),
	//		'email' => $request->input('email'),
	//		'password' => bcrypt($request->input('password'))
	//	]);
	//	$user->save();

	//	Auth::login($user);

	//	return response()->json([
	//		'message' => 'Usuário Criado com Sucesso'
	//	], 201);
	//}
//	public function login(Request $request)
//{

//	$http = new Client();
//      try {
//         $response = $http->post(config('services.passport.login_endpoint'),[ 
//           'form_params' => [
//              'grant_type' => 'password',
//              'client_id' => config('services.passport.client_id'),
//              'client_secret' => config('services.passport.client_secret'),
//               'username' => $request->username,
//               'password' => $request->password,
//           ]
//        ]);
//		$response = $response->getBody()->getContents();

//		} catch (\GuzzleHttp\Exception\BadResponseException $e) {
//            if ($e->getCode() === 400) {
//                return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
//            } else if ($e->getCode() === 401) {
//                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
//            }
//            return response()->json('Something went wrong on the server.', $e->getCode());
//        }


//    }

// User Login
//public function login()
//{
//	if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
//		return $this->getTokenAndRefreshToken(request('email'), request('password'));
//	} 
//	else { 
//		return response()->json(['error'=>'Unauthorised'], 401); 
//	} 
//}
// Generate Bearer Token and Refresh Token
//public function getTokenAndRefreshToken($email, $password) { 
//	$oClient = OClient::where('password_client', 1)->first();
//	$http = new Client;
//	$response = $http->request('POST', env('APP_URL').'/oauth/token', [
//		'form_params' => [
//			'grant_type' => 'password',
//			'client_id' => $oClient->id,
//			'client_secret' => $oClient->secret,
//			'username' => $email,
//			'password' => $password,
//			'scope' => '*',
//		],
//	]);

//	$result = json_decode((string) $response->getBody(), true);
//	return response()->json($result, $this->successStatus);
//}

	// public function login(ServerRequestInterface $request)
    //{
    //    $parsedBody = $request->getParsedBody();

    //    $client = $this->getClient($parsedBody['client_name']);

    //    $parsedBody['username'] = $parsedBody['email'];
    //    $parsedBody['grant_type'] = 'password';
    //    $parsedBody['client_id'] = $client->id;
    //    $parsedBody['client_secret'] = $client->secret;

    //    // since it is not required by passport
    //    unset($parsedBody['email'], $parsedBody['client_name']);

    //    return parent::issueToken($request->withParsedBody($parsedBody));
    //}
	//private function getClient(string $name)
    //{
    //    return Passport::client()
    //        ->where([
    //            ['name', $name],
    //            ['password_client', 1],
    //            ['revoked', 0]
    //        ])
    //        ->first();
    //}

	//public function login(Request $request)
    //{
    //    $data = $request->validate([
    //        //'email' => 'email|required',
	//		'username' => 'required|email',
    //        'password' => 'required'
    //    ]);

    //    if (!auth()->attempt($data)) {
    //        return response(['error_message' => 'Incorrect Details. 
    //        Please try again']);
    //    }

    //    $token = auth()->user()->createToken('API Token')->accessToken;

    //    return response(['user' => auth()->user(), 'token' => $token]);

    //}
	//public function login(Request $request)
    //{
	//	$this->validate($request,[
	//		'username' => 'required|email',
	//		'password' => 'required'
	//   ]);
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
	//public function login (Request $request)
    //{
    //    $http= new \GuzzleHttp\Client();
	//	$response = $http->post(config('services.passport.login_endpoint'),[ 
    //    'headers' => [
    //        'cache-control' => 'no-cache',
    //        'Content-Type' => 'application/x-www-form-urlencoded'
    //  ],
    //    'form_params' => [
	//		'client_id' => config('services.passport.client_id'),
	//		'client_secret' => config('services.passport.client_secret'),
    //        'grant_type' => 'password',
    //        'username' => 'teste@gmail.com',
    //        'password' => 'irg@9351982',
    //        'scope' => '',
    //    ],
    //  ]);
    ////return json_decode((string) $response->getBody()->getContents(), true);
	//return $response->getBody();


    //}
	//public function login(Request $request){
	//	$email = $request->email;
	//	$password = $request->password;
		
	//	//Check if field is not empty
	//	if (empty($email) or empty($password)) {
	//		return response()->json(['status' => 'error', 'message' => 'You must fill all fields']);
	//	}       
	//	$user = User::where('email', '=', $email)->exists();
	//	if ($user === false) {
	//		return response()->json(['status' => 'error', 'message' => 'User doesnt exist']);
	//	}                               
	//	//$client = new \GuzzleHttp\Client();
		
	//	try{
	//		$tokenRequest = $request->create(           
	//			env('PASSPORT_LOGIN_ENDPOINT'),
	//			'POST'
	//		);
	
	//		$tokenRequest->request->add([
	//			"grant_type" => "password",
	//			"username" => $request->email,              
	//			"password" => $request->password,
	//			"client_id" => env('PASSPORT_CLIENT_ID'),
	//			"client_secret" => env('PASSPORT_CLIENT_SECRET'),
	//		]);
	
	//		$response = app()->handle($tokenRequest);
	//		return $response;
	//	} catch (\Exception $e) {
	//		return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
	//	}
	//}
//	public function login(Request $request)
//{
//    $http = new \GuzzleHttp\Client;

//    try {
//        $response = $http->post(config('services.passport.login_endpoint'), [
//            'form_params' => [
//                'grant_type' => 'password',
//                'client_id' => config('services.passport.client_id'),
//                'client_secret' => config('services.passport.client_secret'),
//                'username' => $request->username,
//                'password' => $request->password,
//            ]
//        ]);
//        return $response->getBody();
//    } catch (\GuzzleHttp\Exception\BadResponseException $e) {
//        if ($e->getCode() === 400) {
//            return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
//        } else if ($e->getCode() === 401) {
//            return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
//        }
//        return response()->json('Something went wrong on the server.', $e->getCode());
//    }
//}
//public function login(Request $request)
//{
//	$this->validate($request,[
//		'username' => 'required|email',
//		'password' => 'required'
//   ]);

//  $http = new \GuzzleHttp\Client;

//  try {
//	$response = $http->post(config('services.passport.login_endpoint'), [
//		//'verify' => false,
//		'verify'  => ( env( 'APP_ENV' ) === 'local' ) ? false : true,
//		'form_params' => [
//			'grant_type' => 'password',
//			'client_id' => config('services.passport.client_id'),
//			'client_secret' => config('services.passport.client_secret'),
//			'scope' => '',
//			'username' => $request->username,
//			'password' => $request->password,
//		]
//	]);
//	return $response->getBody()->getContents();
//  } catch (\GuzzleHttp\Exception\BadResponseException $e) {
//	  if ($e->getCode() === 400) {
//		  return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
//	  } else if ($e->getCode() === 401) {
//		  return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
//	  }
//	  return $e;
//  }
//}
public function registrar(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);
		//$user = new User([
		//	'name' => $request->input('name'),
		//	'email' => $request->input('email'),
		//	'password' => bcrypt($request->input('password'))
		//]);
 
        $user = User::create([
            'name' => $request->input('name'),
	          'email' => $request->input('email'),
	          'password' => bcrypt($request->input('password'))
        ]);
       
        $token = $user->createToken('LaravelAuthApp')->accessToken;
 
        return response()->json(['token' => $token], 200);
    }

	public function login(Request $request)
    {
        $data = [
            'email' => $request->username,
            'password' => $request->password
        ];
 
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    } 

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
