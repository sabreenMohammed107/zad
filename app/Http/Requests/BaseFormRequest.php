<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class BaseFormRequest extends FormRequest
{

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $res = [
            'code' => 422, //code Error
            'message' => 'Validation error', //Massage Return in Response Data field
            'status'=>'failed',
            'error' => $validator->errors()->first() //Validator Errors
        ];
        //return response()->json($res,200,JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            throw new HttpResponseException(response()->json($res
        , 422));
    }



}
