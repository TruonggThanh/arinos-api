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
     *                     "email":"daugherty.ezequiel@example.org",
     *                     "password":"12345678"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="accessToken", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcmlub3MtYXBpLmxvY2FsXC9hcGlcL2F1dGhcL2xvZ2luIiwiaWF0IjoxNjUyODQyNzQ3LCJleHAiOjE2NTI4NDYzNDcsIm5iZiI6MTY1Mjg0Mjc0NywianRpIjoiU1NNaWgzSktkUFN4MXBIcyIsInN1YiI6NTAsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.OMnalkpV9rdBeH1Siq3G63mj3hCVtBdAp-iLn9G7q1M"),
     *              @OA\Property(property="tokenType", type="string", example="bearer"),
     *              @OA\Property(property="expiresIn", type="number", example=3600),
     *              @OA\Property(
     *                  property="profile", 
     *                  type="object", 
     *                  example={{
     *                      "id":50,
     *                      "companyId": 10,
     *                      "name": "Ms. Gina Zulauf",
     *                      "nameRomaji": "Mr. Eugene Collins V",
     *                      "email": "lynch.emmanuelle@example.org",
     *                      "sex": 0,
     *                      "dateOfBirth": "1997-07-30",
     *                      "phone": "+1.229.803.2888",
     *                      "roleId": 1,
     *                      "position": "Chief Executive Officer",
     *                      "avatar": "Lynn Denesik.png",
     *                      "status": 1,
     *                  },
     *              }),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Unauthenticated"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Forbidden"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Bad validation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Bad validation"),
     *          )
     *      )
     * )
     */

    public function login(Request $request)
    {
        // return $this->authService->login($request->all());
        try {
            return $this->authService->login($request->all());
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            \Log::error($e->getMessage());
            return $this->sendResponseUnauthenRequest($e->getMessage());
        } catch(\Exception $e) {
            \Log::error($e->getMessage());
            return $this->sendResponseBasedRequest($e->getMessage());
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

     /**
     * Logout
     * @OA\Post (
     *     path="/api/auth/logout",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="token",
     *                          type="string"
     *                      ),
     *                 ),
     *                 example={
     *                     "token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcmlub3MtYXBpLmxvY2FsXC9hcGlcL2F1dGhcL2xvZ2luIiwiaWF0IjoxNjUyODU1NzMzLCJleHAiOjE2NTI4NTkzMzMsIm5iZiI6MTY1Mjg1NTczMywianRpIjoiZ0dBU296cWlkTHpzaDlicCIsInN1YiI6NywicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.MlWeh6y5QJAOkOW-ImDF-VKNNOQ_HbKr9uc0eheGtQM",
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="expiresIn", type="string", example="Logged out successfully"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Unauthenticated"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Forbidden"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Bad validation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Bad validation"),
     *          )
     *      )
     * )
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

    /**
     * Refresh token
     * @OA\Post (
     *     path="/api/auth/refresh",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="token",
     *                          type="string"
     *                      ),
     *                 ),
     *                 example={
     *                     "token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcmlub3MtYXBpLmxvY2FsXC9hcGlcL2F1dGhcL3JlZnJlc2giLCJpYXQiOjE2NTI4NTUzOTQsImV4cCI6MTY1Mjg1OTAwNywibmJmIjoxNjUyODU1NDA3LCJqdGkiOiJxRzVRb3QwR2ZRUVRQQmVXIiwic3ViIjo3LCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0._FxPOKL9DP64mrLKbZiZN1K8IwgRAEaFWkh3ivXUcNA",
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="accessToken", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9hcmlub3MtYXBpLmxvY2FsXC9hcGlcL2F1dGhcL2xvZ2luIiwiaWF0IjoxNjUyODQyNzQ3LCJleHAiOjE2NTI4NDYzNDcsIm5iZiI6MTY1Mjg0Mjc0NywianRpIjoiU1NNaWgzSktkUFN4MXBIcyIsInN1YiI6NTAsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.OMnalkpV9rdBeH1Siq3G63mj3hCVtBdAp-iLn9G7q1M"),
     *              @OA\Property(property="tokenType", type="string", example="bearer"),
     *              @OA\Property(property="expiresIn", type="number", example=3600),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Unauthenticated"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Forbidden"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Bad validation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Bad validation"),
     *          )
     *      )
     * )
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
