<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class Controller extends BaseController
{

 /**
 * @OA\Info(title="kiwi Api", version="0.1")
  * @OA\SecurityScheme(
   *securityScheme="Bearer",
   *type="http",
   *scheme="bearer",
   *bearerFormat="JWT"
*)
 */
 /*@CrossOrigin(origins = "httpS://kiwi.com/", maxAge = 3600)
@RestController
*/
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function dataResponse($data , $message = null, $code = null){

        $success = [
            'message' => $code ? $code : 104,
            'error' => false,
        ];

        $success = array_merge($success, $data);

        return response()->json($success, 200);
    }

    public function successResponse($message = null, $code = null){
        $success = [
            'code' => $code ? $code : 200,
            'message' => $message ? $message : 'success'
        ];

        return response()->json($success, 200);
    }

    public function errorResponse($message , $code){
        $error = [
            'code' => $code,
            'message' => $message
        ];

        return response()->json($error, 401);
    }

    public function errorResponseWithstatus($message , $code){
        $error = [
            'code' => $code,
            'message' => $message
        ];

        return response()->json($error, $code);
    }


/**
  * Gera a paginação dos itens de um array ou collection.
  *
  * @param array|Collection      $items
  * @param int   $perPage
  * @param int  $page
  * @param array $options
  *
  * @return LengthAwarePaginator
  */
public function paginateCollection($items, $perPage = 15, $page = null, $options = [])
{
	$page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

	$items = $items instanceof Collection ? $items : Collection::make($items);

    $lap = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);

    return [
        'current_page' => $lap->currentPage(),
        'data' => $lap ->values(),
        'first_page_url' => $lap ->url(1),
        'from' => $lap->firstItem(),
        'last_page' => $lap->lastPage(),
        'last_page_url' => $lap->url($lap->lastPage()),
        'next_page_url' => $lap->nextPageUrl(),
        'per_page' => $lap->perPage(),
        'prev_page_url' => $lap->previousPageUrl(),
        'to' => $lap->lastItem(),
        'total' => $lap->total(),
    ];
}
/**
     * convert error from array to string.
     *
     * @return sreting.
     */
    public function convertErrorsToString($errorArray)
    {
        $valArr = array();
        foreach ($errorArray->toArray() as $key => $value) {
            $errStr = $key.' '.$value[0];
            //return $errStr;
            array_push($valArr, $errStr);
        }
        // if(!empty($valArr)){
        //     $errStrFinal = implode(',', $valArr);
        // }
        return $this->sendError('Validation Error', $valArr);

    }

     /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'status' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

}
