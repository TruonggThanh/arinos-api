<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseHelpers;
use Illuminate\Support\Facades\Validator;
use App\Services\AuthService;

class AuthController extends Controller
{
    use ResponseHelpers;

    private $authService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;

        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

/**
     * Login
     * @OA\Post (
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "title":"thanh.tt@scuti.asia",
     *                     "password":"12345678"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="accessToken", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcmlub3MtYXBpLmxvY2FsXC9hcGlcL2F1dGhcL2xvZ2luIiwiaWF0IjoxNjUyODQyNzQ3LCJleHAiOjE2NTI4NDYzNDcsIm5iZiI6MTY1Mjg0Mjc0NywianRpIjoiU1NNaWgzSktkUFN4MXBIcyIsInN1YiI6NTAsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.OMnalkpV9rdBeH1Siq3G63mj3hCVtBdAp-iLn9G7q1M"),
     *              @OA\Property(property="refreshToken", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcmlub3MtYXBpLmxvY2FsXC9hcGlcL2F1dGhcL2xvZ2luIiwiaWF0IjoxNjUyODQyNzQ3LCJleHAiOjE2NTI4NDYzNDgsIm5iZiI6MTY1Mjg0Mjc0OCwianRpIjoiejVUZlozR3hLWGJBSG9ZYSIsInN1YiI6NTAsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.yj2GFcUkAZu1c7ceGeK3wh08DESebr5rAAUPKWuzIsA"),
     *              @OA\Property(property="tokenType", type="string", example="bearer"),
     *              @OA\Property(property="expiresIn", type="number", example=3600),
     *              @OA\Property(
     *                  property="profile", 
     *                  type="object", 
     *                  example={{
     *                      "id":50,
     *                      "companyId":10,
     *                      "visitingCardId":2,
     *                      "companyId":10,
     *                      "name":"Ms. Gina Zulauf",
     *                      "email":"frami.iliana@example.com",
     *                      "phone":"+1.229.803.2888",
     *                      "roleId":1,
     *                      "sex":0,
     *                      "dateOfBirth":"1997-07-30",
     *                      "status":1,
     *                  },
     *              }),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      )
     * )
     */

    public function login(Request $request)
    {
        return $this->authService->login($request->all());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return $this->sendResponseOk([], __('Logged out successfully'));
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->sendResponseOk([
            'accessToken' => auth()->refresh(),
            'tokenType' => 'bearer',
            'expiresIn' => auth()->factory()->getTTL() * 60,
        ], __('Refresh token successfully'));
    }
}
