<?php

namespace App\Http\Requests;

use App\Helpers\ResponseHelpers;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseApiRequest extends FormRequest
{
    use ResponseHelpers;

    protected function failedValidation(Validator $validator)
    {
        if (request()->expectsJson()) {
            throw new HttpResponseException($this->sendResponseErrorsValidate([], $validator->errors()));
        }
    }
}
