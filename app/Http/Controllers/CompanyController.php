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
