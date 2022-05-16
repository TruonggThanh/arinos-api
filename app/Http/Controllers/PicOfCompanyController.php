<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseHelpers;
use Illuminate\Support\Facades\Validator;
use App\Services\PicOfCompanyService;
use App\Http\Resources\PicOfCompany\ListPicCompanyAccountResource;
use App\Http\Resources\PicOfCompany\ListPicCompanyAccountCollection;

class PicOfCompanyController extends Controller
{
    use ResponseHelpers;

    private $picOfCompanyServiceService;

    /**
     * Create a new PicOfCompanyController instance.
     *
     * @return void
     */
    public function __construct(PicOfCompanyService $picOfCompanyServiceService)
    {
        $this->picOfCompanyServiceService = $picOfCompanyServiceService;
    }

    public function listPicCompanyAccount()
    {
        $listAccount = $this->picOfCompanyServiceService->listPicCompanyAccount();

        if (!$listAccount) {
            return $this->sendResponseNotFound();
        }

        return $this->sendResponseOk(['picCompanyAccount' => new ListPicCompanyAccountCollection($listAccount)]);
    }
}
