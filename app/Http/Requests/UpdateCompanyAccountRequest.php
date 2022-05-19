<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyAccountRequest extends BaseApiRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|numeric|exists:users,id',
            'companyId' => 'required|numeric',
            'name' => 'required',
            'nameRomaji' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->id,
            'sex' => 'required|numeric',
            'dateOfBirth' => 'required',
            'phone' => 'required',
            'roleId' => 'required|numeric',
            'position' => 'required',
            'avatar' => 'required',
            'password' => 'required|min:6|max:18',
            'status' => 'required|numeric',
        ];
    }
}
