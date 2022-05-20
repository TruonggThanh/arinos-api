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
    'middleware' => ['jwt.verify']
], function () {
    Route::group([
        'prefix' => 'operator/companies',
    ], function () {
        Route::get('{companyId}', [CompanyController::class, 'listCompanyAccount']);
        Route::post('', [CompanyController::class, 'createCompanyAccount']);
        Route::put('', [CompanyController::class, 'updateCompanyAccount']);
    });

    Route::group([
        'prefix' => 'picOfCompany/companies',
    ], function () {
        Route::post('send-mail-invitation', [CompanyController::class, 'sendMailInvitation']);
    });
});