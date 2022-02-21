<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
       
        $name = $request->name;
        $email    = $request->email;
        $password = $request->password;
        $user     = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password)]);
        $token = $user->createToken('user')->accessToken;
        $registerData=['name' => $user->name, 'email' => $user->email,'token' => $token];
        return $this->dataResponse(['data'=>$registerData]);
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($credentials)) {
            $user=auth()->user();
            return $this->dataResponse(['data'=>$user,"token"=>$user->createToken('user')->accessToken]);

           } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }
}