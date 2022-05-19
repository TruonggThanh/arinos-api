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
            'name' => 'required',
            'nameRomaji' => 'required',
            'email' => 'required|email|unique:users',
            'sex' => 'required|numeric',
            'dateOfBirth' => 'required',
            'phone' => 'required',
            'roleId' => 'required|numeric',
            'position' => 'required',
            'avatar' => 'required',
            'password' => 'required|min:6|max:18',
            'cpassword' => 'required|min:6|max:18|same:password',
            'status' => 'required|numeric',
        ];
    }
}
