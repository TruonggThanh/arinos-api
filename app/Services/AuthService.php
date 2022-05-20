<?php

namespace App\Services;

use Scuti\Admin\ServiceGenerator\Services\ScutiBaseService;
use App\Helpers\ResponseHelpers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Users\ProfileResource;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

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
            throw new UserNotDefinedException("This account does not exist");
        }

        if (Auth::user()->deleted_at != null) {
            auth()->logout();
            throw new UserNotDefinedException("This account does not exist");
        }

        return $this->sendResponseOk([
            'accessToken' => $token,
            'tokenType' => 'bearer',
            'expiresIn' => auth()->factory()->getTTL() * 30,
            'profile' => new ProfileResource(Auth::user()),
        ], __('Login successfully'));
    }
}
