<?php

namespace App\Http\Requests\Acl;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class SyncRoleFormRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'roles.*' => 'required|string|min:1'
        ];


    }

    public function messages()
    {
        return [
            'roles.*.required' => '1112', //Action lead_id  is required
        ];
    }

}
