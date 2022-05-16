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

class CompanyController extends Controller
{
    use ResponseHelpers;

    private $companyServiceService;

    /**
     * Create a new PicOfCompanyController instance.
     *
     * @return void
     */
    public function __construct(CompanyService $companyServiceService)
    {
        $this->companyServiceService = $companyServiceService;
    }

    public function listPicCompanyAccount()
    {
        $listAccount = $this->companyServiceService->listPicCompanyAccount();

        if (!$listAccount) {
            return $this->sendResponseNotFound();
        }

        return $this->sendResponseOk(['picCompanyAccount' => new CompanyAccountCollection($listAccount)]);
    }
}
