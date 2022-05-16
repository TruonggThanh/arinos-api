<?php

namespace App\Services;

use Scuti\Admin\ServiceGenerator\Services\ScutiBaseService;
use App\Helpers\ResponseHelpers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CompanyRepositoryEloquent;

class CompanyService extends ScutiBaseService
{
    use ResponseHelpers;

    protected $repository;

    public function __construct(
        CompanyRepositoryEloquent $repository
    ){
        $this->repository = $repository;
    }

    public function listPicCompanyAccount()
    {
        $listAccount = $this->repository->findWhere([
            'role_id' => config('constants.rolePicOfCompany'),
            'is_deleted' => config('constants.isDefault'),
        ]);

        return $listAccount;
    }
}
