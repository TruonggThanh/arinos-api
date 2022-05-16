<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyAccountRequest extends BaseApiRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'companyId' => 'required|numeric',
            'visitingCardId' => 'required|numeric',
            'name' => 'required',
            'sex' => 'required|numeric',
            'roleId' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required|min:6|max:18',
            'cpassword' => 'required|min:6|max:18|same:password',
            'status' => 'required|numeric',
        ];
    }
}
