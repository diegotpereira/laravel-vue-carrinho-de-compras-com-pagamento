<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
	protected $redirecTo = '/home';

	public function __construct()
    {
        $this->middleware('guest');
    }

	protected function create(array $data) 
	{
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => Hash::make($data['password'])
		]);
	}
}
