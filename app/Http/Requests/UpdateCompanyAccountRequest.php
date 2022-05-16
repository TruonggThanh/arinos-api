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
            'visitingCardId' => 'required|numeric',
            'name' => 'required',
            'sex' => 'required|numeric',
            'roleId' => 'required|numeric',
            'email' => 'required|email|unique:users,email,'.$this->id,
            'phone' => 'required',
            'password' => 'required|min:6|max:18',
            'status' => 'required|numeric',
        ];
    }
}
