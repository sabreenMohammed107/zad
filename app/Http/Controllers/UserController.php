<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserDataResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Post(
     *
     *      path="/api/get_user_by_id",
     *      operationId="getuser",
     *      tags={"User"},
     *      summary="get  user by id",
     *      description="Returns user data ",
     * security={{"Bearer": {}}},
     *     @OA\RequestBody(
     *         required=true,
    *        @OA\MediaType(
    *       mediaType="application/json",
    *       @OA\Schema(
    *         @OA\Property(
    *           property="get_user_by_id",
    *           description="1",
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

    public function get_user_by_id(Request $request)
    {

        if (!empty($request->get("get_user_by_id"))) {
            $user = User::where('id',$request->get("get_user_by_id"))->firstOrFail();
        }else{
            return $this->sendError('user not found.');
        }


        return $this->dataResponse(['data' => UserDataResource::make($user)]);
    }
}
