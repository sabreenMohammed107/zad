<?php

namespace App\Http\Requests\Acl;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class AclFormRequest extends BaseFormRequest
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
        $roles = config('acl.roles');
        return [
            'name' => [ 'required', 'string'],
            'permissions'=>'nullable|array|min:1'
        ];
    }
}
