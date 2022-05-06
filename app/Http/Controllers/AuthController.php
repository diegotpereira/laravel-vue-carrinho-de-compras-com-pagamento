<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use GuzzleHttp\Client;

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

	public function login(Request $request)
{
 // 'http://laravel-vue-shipingcart-paymentgw/oauth/token'
 //2
 //'JjXJVbuAYxeyCAlUjuuOZJWCsuh1kJrLZtZpZjRv'
      $this->validate($request,[
           'username' => 'required|email',
           'password' => 'required'
      ]);

     $http = new \GuzzleHttp\Client();
	//$http = new \GuzzleHttp\Client;

      try {
         
		$response = $http->request('POST', env('APP_URL').'/oauth/token', [
           'form_params' => [
              'grant_type' => 'password',
              'client_id' => '3',
              'client_secret' => 'BWLuNKeUJZJF6tTB7T20y4Ctk7I5U2OZxxCB8Ejs',
               'username' => $request->username,
               'password' => $request->password,
           ]
        ]);
		
		return $response->getBody();

      } catch(\GuzzleHttp\Exception\BadResponseException $e){
      	if ($e->getCode() == 422) {

      	  return response()->json('Invalid Request, plese enter a username', $e->getCode());
      	}
      	else if ($e->getCode() == 401) {
      		
      		return response()->json('Invalid username Or password.try again', $e->getCode());
      	}

      	return response()->json('Something want wrrong ont the server,', $e->getCode());
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
