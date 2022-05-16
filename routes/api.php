<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::group([
    'prefix' => 'company',
    'middleware' => ['jwt.verify']
], function () {
    Route::get('list-pic-company-account', [CompanyController::class, 'listPicCompanyAccount']);
    Route::post('create-company-account', [CompanyController::class, 'createCompanyAccount']);
    Route::post('update-company-account', [CompanyController::class, 'updateCompanyAccount']);
});