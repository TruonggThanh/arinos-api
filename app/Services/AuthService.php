<?php

namespace App\Services;

use Scuti\Admin\ServiceGenerator\Services\ScutiBaseService;
use App\Helpers\ResponseHelpers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Users\ProfileResource;

class AuthService extends ScutiBaseService
{
    use ResponseHelpers;

    public function __construct(

    ){

    }

    public function login($request)
    {
        $validator = Validator::make($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        $credentials = request(['email', 'password']);

        $token = auth()->attempt($credentials);

        if (!$token) {
            return $this->sendResponseBadValidate($validator->messages());
        }

        if (Auth::user()->is_deleted == config('constants.isDelete')) {
            auth()->logout();
            return $this->sendResponseBadValidate([], __('Login fail'));
        }

        return $this->sendResponseOk([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'profile' => new ProfileResource(Auth::user()),
        ], __('Login successfully'));
    }
}
