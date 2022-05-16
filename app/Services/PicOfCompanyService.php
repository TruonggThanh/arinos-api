<?php

namespace App\Services;

use Scuti\Admin\ServiceGenerator\Services\ScutiBaseService;
use App\Helpers\ResponseHelpers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Users\ProfileResource;
use App\Repositories\PicOfCompanyRepositoryEloquent;

class PicOfCompanyService extends ScutiBaseService
{
    use ResponseHelpers;

    protected $repository;

    public function __construct(
        PicOfCompanyRepositoryEloquent $repository
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
