<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PicOfCompanyController;

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::group([
    'prefix' => 'operator',
    'middleware' => ['jwt.verify']
], function () {
    Route::get('list-pic-company-account', [PicOfCompanyController::class, 'listPicCompanyAccount']);
});