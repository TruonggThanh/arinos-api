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
     * Company
     * @OA\Get (
     *     path="/api/company/list-pic-company-account",
     *     tags={"Company"},
     *     security={
     *         {"jwt_token": {}}
     *     },
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
     *                         property="visitingCardId",
     *                         type="number",
     *                         example=15
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Prof. Jamir Stanton Sr."
     *                     ),
     *                     @OA\Property(
     *                         property="sex",
     *                         type="number",
     *                         example="0"
     *                     ),
     *                     @OA\Property(
     *                         property="roleId",
     *                         type="number",
     *                         example=2
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="shanna.breitenberg@example.org"
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

    public function listPicCompanyAccount()
    {
        $listAccount = $this->companyService->listPicCompanyAccount();

        if (!$listAccount) {
            return $this->sendResponseNotFound();
        }

        return $this->sendResponseOk(['picCompanyAccount' => new CompanyAccountCollection($listAccount)]);
    }

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
