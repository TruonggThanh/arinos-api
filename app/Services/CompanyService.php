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
            'deleted_at' => null,
        ]);

        return $listAccount;
    }

    public function createCompanyAccount($request)
    {
        $createdData = [
            'company_id' => $request->companyId,
            'name' => $request->name,
            'name_romaji' => $request->nameRomaji,
            'email' => $request->email,
            'sex' => $request->sex,
            'date_of_birth' => $request->dateOfBirth,
            'phone' => $request->phone,
            'role_id' => $request->roleId,
            'position'=> $request->position,
            'avatar'=> $request->avatar,
            'password' => \Hash::make($request->password),
            'status' => $request->status,
        ];

        $createAccount = $this->repository->create($createdData);

        return $createAccount;
    }
    
    public function updateCompanyAccount($request)
    {
        $updatedData = [
            'company_id' => $request->companyId,
            'name' => $request->name,
            'name_romaji' => $request->nameRomaji,
            'email' => $request->email,
            'sex' => $request->sex,
            'date_of_birth' => $request->dateOfBirth,
            'phone' => $request->phone,
            'role_id' => $request->roleId,
            'position'=> $request->position,
            'avatar'=> $request->avatar,
            'password' => \Hash::make($request->password),
            'status' => $request->status,
        ];

      

        $updateAccount = $this->repository->update($updatedData, $request->id);

        return $updateAccount;
    }
}
