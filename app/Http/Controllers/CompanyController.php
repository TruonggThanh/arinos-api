<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseHelpers;
use Illuminate\Support\Facades\Validator;
use App\Services\CompanyService;
use App\Http\Resources\Company\CompanyAccountResource;
use App\Http\Resources\Company\CompanyAccountCollection;
use App\Http\Requests\CreateCompanyAccountRequest;
use App\Http\Requests\UpdateCompanyAccountRequest;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    use ResponseHelpers;

    private $companyService;

    /**
     * Create a new PicOfCompanyController instance.
     *
     * @return void
     */
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

     /**
     * List company account
     * @OA\Get (
     *     path="/api/company/list-company-account/{companyId}",
     *     tags={"Company"},
     *     security={
     *         {"jwt_token": {}}
     *     },
     *     @OA\Parameter(
     *         in="path",
     *         name="companyId",
     *         required=true,
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example=4
     *                     ),
     *                     @OA\Property(
     *                         property="companyId",
     *                         type="number",
     *                         example=6
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Prof. Jamir Stanton Sr."
     *                     ),
     *                     @OA\Property(
     *                         property="nameRomaji",
     *                         type="string",
     *                         example="Jamir Stanton"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="cfunk@example.com"
     *                     ),
     *                     @OA\Property(
     *                         property="sex",
     *                         type="number",
     *                         example=0
     *                     ),
     *                     @OA\Property(
     *                         property="dateOfBirth",
     *                         type="string",
     *                         example="2022-05-19"
     *                     ),
     *                     @OA\Property(
     *                         property="phone",
     *                         type="string",
     *                         example="+19732341225"
     *                     ),
     *                     @OA\Property(
     *                         property="roleId",
     *                         type="number",
     *                         example=2
     *                     ),
     *                     @OA\Property(
     *                         property="position",
     *                         type="string",
     *                         example="Chief Executive Officer"
     *                     ),
     *                     @OA\Property(
     *                         property="avatar",
     *                         type="string",
     *                         example="Yasmin Kuphal.png"
     *                     ),
     *                     @OA\Property(
     *                         property="status",
     *                         type="number",
     *                         example=0
     *                     ),
     *                 )
     *             )
     *         ),
     *     ),
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
     *      ),
     * )
     */

    public function listCompanyAccount($companyId)
    {
        if (auth()->user()->role_id != config('constants.rolePicOfCompany') && auth()->user()->role_id != config('constants.roleOperator')) {
            return $this->sendResponseForbidden();
        }

        $listAccount = $this->companyService->listCompanyAccount($companyId);

        if ($listAccount->empty()) {
            return $this->sendResponseNotFound();
        }

        return $this->sendResponseOk(['picCompanyAccount' => new CompanyAccountCollection($listAccount)]);
    }

        /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * Create company account
     * @OA\Post (
     *     path="/api/company/create-company-account",
     *     tags={"Company"},
     *     security={
     *         {"jwt_token": {}}
     *     },
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="companyId",
     *                          type="number"
     *                      ),
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="nameRomaji",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="sex",
     *                          type="number"
     *                      ),
     *                      @OA\Property(
     *                          property="dateOfBirth",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="phone",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="roleId",
     *                          type="number"
     *                      ),
     *                      @OA\Property(
     *                          property="position",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="avatar",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="cpassword",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="status",
     *                          type="number"
     *                      ),
     *                 ),
     *                  example={
     *                      "companyId": 19,
     *                      "name": "Afton Schuster",
     *                      "nameRomaji": "Jillian Jerde",
     *                      "email": "cfunk@example.com",
     *                      "sex": 0,
     *                      "dateOfBirth": "2022-05-19",
     *                      "phone": "+19732341225",
     *                      "roleId": 2,
     *                      "position": "Chief Executive Officer",
     *                      "avatar": "Yasmin Kuphal.png",
     *                      "password": "12345678",
     *                      "cpassword": "12345678",
     *                      "status": 0
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

    public function createCompanyAccount(CreateCompanyAccountRequest $request)
    {
        DB::beginTransaction();
        try {
            $createAccount = $this->companyService->createCompanyAccount($request);

            DB::commit();

            return $this->sendResponseCreated(['createCompanyAccount' => new CompanyAccountResource($createAccount)], __('common.flash_message.create_success'));
        } catch(\Exception $e) {
            \Log::error($e->getMessage());

            DB::rollBack();

            return $this->sendResponseBadRequest($e->getMessage());
        }
    }

     /**
     * Update company account
     * @OA\Post (
     *     path="/api/company/update-company-account",
     *     tags={"Company"},
     *     security={
     *         {"jwt_token": {}}
     *     },
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="id",
     *                          type="number"
     *                      ),
     *                      @OA\Property(
     *                          property="companyId",
     *                          type="number"
     *                      ),
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="nameRomaji",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="sex",
     *                          type="number"
     *                      ),
     *                      @OA\Property(
     *                          property="dateOfBirth",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="phone",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="roleId",
     *                          type="number"
     *                      ),
     *                      @OA\Property(
     *                          property="position",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="avatar",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="status",
     *                          type="number"
     *                      ),
     *                 ),
     *                  example={
     *                      "id": 1,
     *                      "companyId": 19,
     *                      "name": "Afton Schuster",
     *                      "nameRomaji": "Jillian Jerde",
     *                      "email": "cfunk@example.com",
     *                      "sex": 0,
     *                      "dateOfBirth": "2022-05-19",
     *                      "phone": "+19732341225",
     *                      "roleId": 2,
     *                      "position": "Chief Executive Officer",
     *                      "avatar": "Yasmin Kuphal.png",
     *                      "password": "12345678",
     *                      "status": 0
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

    public function updateCompanyAccount(UpdateCompanyAccountRequest $request)
    {
        DB::beginTransaction();
        try {
            $updateAccount = $this->companyService->updateCompanyAccount($request);

            DB::commit();

            return $this->sendResponseCreated(['updateCompanyAccount' => new CompanyAccountResource($updateAccount)], __('common.flash_message.update_success'));
        } catch(\Exception $e) {
            \Log::error($e->getMessage());

            DB::rollBack();

            return $this->sendResponseBadRequest($e->getMessage());
        }
    }
}
