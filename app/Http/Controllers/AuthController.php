<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\RegisterResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
    * @OA\Post(
    *
    *      path="/api/register",
    *      operationId="registeruser",
    *      tags={"auth"},
    *      summary="register new user",
    *      description="Returns user data and token",
    *     @OA\RequestBody(
    *         required=true,
    *        @OA\MediaType(
    *       mediaType="application/json",
    *       @OA\Schema(
    *         @OA\Property(
    *           property="name",
    *           description="Name of the new user.",
    *           type="string",
    *         ),       
    *         @OA\Property(
    *           property="email",
    *           description="Email address of the new user.",
    *           type="string",
    *         ),
    *        @OA\Property(
    *           property="password",
    *           description="name  of the new user.",
    *           type="string",
    *         ),
    *        @OA\Property(
    *           property="c_password",
    *           description="password confirmation.",
    *           type="string",
    *         ),
     *        @OA\Property(
    *           property="firebase_id",
    *           description="firebase_id.",
    *           type="string",
    *         ),
    *        @OA\Property(
    *           property="mobile",
    *           description="mobile.",
    *           type="string",
    *         ),
    *        @OA\Property(
    *           property="profile",
    *           description="profile image.",
    *           type="file",
    *         ),
    *        @OA\Property(
    *           property="type",
    *           description="email / gmail / fb / mobile / apple",
    *           type="string",
    *         ),
    *        @OA\Property(
    *           property="fcm_id",
    *           description="fcm_id",
    *           type="string",
    *         ),
    *        @OA\Property(
    *           property="coins",
    *           description="coins.",
    *           type="string",
    *         ),
    *        @OA\Property(
    *           property="refer_code",
    *           description="refer_code.",
    *           type="string",
    *         ), 
    *        @OA\Property(
    *           property="friends_code",
    *           description="friends_code.",
    *           type="string",
    *         ), 
     *        @OA\Property(
    *           property="status",
    *           description="1 - Active & 0 Deactive .",
    *           type="string",
    *         ),              
    *       ),
    *     ),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function register(RegisterRequest $request)
    {
        $data=$request->all();
        $data['password']=bcrypt($request->password);
        $user= User::create($data);
      //  $registerData=['name' => $user->name, 'email' => $user->email,'token' => $token];
        return $this->dataResponse(['data'=>new RegisterResource($user)]);
     //  return new RegisterResource($user);
    }

     /**
     * @OA\Post(
     *
     *      path="/api/login",
     *      operationId="loginuser",
     *      tags={"auth"},
     *      summary="login new user",
     *      description="Returns user data and token",
     *     @OA\RequestBody(
     *         required=true,
    *        @OA\MediaType(
    *       mediaType="application/json",
    *       @OA\Schema(
    *         @OA\Property(
    *           property="email",
    *           description="Email address of the new user.",
    *           type="string",
    *         ),
    *        @OA\Property(
    *           property="password",
    *           description="name  of the new user.",
    *           type="string",
    *         ),
    *       ),
    *     ),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
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