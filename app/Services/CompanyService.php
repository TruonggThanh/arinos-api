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

    public function listCompanyAccount($companyId)
    {
        $listAccount = $this->repository->findWhere([
            'company_id' => $companyId,
            'is_deleted' => config('constants.isDefault'),
        ]);

        return $listAccount;
    }

    public function createCompanyAccount($request)
    {
        $createdData = [
            'company_id' => $request->companyId,
            'visiting_card_id' => $request->visitingCardId,
            'name' => $request->name,
            'sex' => $request->sex,
            'role_id' => $request->roleId,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => \Hash::make($request->password),
            'status' => $request->status,
            'is_deleted' => config('constants.isDefault')
        ];

        $createAccount = $this->repository->create($createdData);

        return $createAccount;
    }
    
    public function updateCompanyAccount($request)
    {
        $updatedData = [
            'company_id' => $request->companyId,
            'visiting_card_id' => $request->visitingCardId,
            'name' => $request->name,
            'sex' => $request->sex,
            'role_id' => $request->roleId,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => \Hash::make($request->password),
            'status' => $request->status,
            'is_deleted' => config('constants.isDefault')
        ];

        $updateAccount = $this->repository->update($updatedData, $request->id);

        return $updateAccount;
    }
}
