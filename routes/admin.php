<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Congraph\Core\Exceptions\BadRequestException;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\AdminApp\FileController;
use App\Http\Controllers\AdminApp\FileServeController;
use App\Http\Controllers\AdminApp\CompanyController;
use App\Http\Controllers\AdminApp\CompanyInfoController;
use App\Http\Controllers\AdminApp\FinancialInfoController;
use App\Http\Controllers\AdminApp\CompanyStandardsController;
use App\Http\Controllers\AdminApp\CompanyServicesController;
use App\Http\Controllers\AdminApp\UsersController;
use App\Http\Controllers\AdminApp\ProcurementsController;
use App\Http\Controllers\AdminApp\ServicesController;
use App\Http\Controllers\AdminApp\CategoriesController;
use App\Http\Controllers\AdminApp\SubcategoriesController;
use App\Http\Controllers\AdminApp\ExportController;



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
|
*/

Route::get('/test', function (Request $request) {
    return 'Test is working!';
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum', 'password.confirm')->delete('/user', function (Request $request) {
    $user = $request->user();
    return $user->delete();
});

Route::name('AdminApp.')
    ->middleware('auth:sanctum')
    ->group(function() {

    Route::prefix('/users')->name('users.')->group(function () {
        // Route::get('/', [UsersController::class, 'index'])
        //     ->name('get');
        Route::get('/{id}', [UsersController::class, 'show'])
            ->name('fetch');
    });

    Route::prefix('/files')->name('file.')->group(function () {
        Route::post('/', [FileController::class, 'store'])
            ->name('create');
        Route::delete('/{id}', [FileController::class, 'destroy'])
            ->name('delete');
        Route::get('/{id}', [FileController::class, 'show'])
            ->where('id', '[0-9]+')
            ->name('fetch');
        Route::get('/{file}', [FileServeController::class, 'index'])
            ->name('serve');
    });

    Route::prefix('/companies')->name('companies.')->group(function () {
        Route::get('/', [CompanyController::class, 'index'])
            ->name('get');
        Route::get('/export/{type}', [ExportController::class, 'index'])
            ->name('export');
        Route::get('/{id}', [CompanyController::class, 'show'])
            ->name('fetch');
        Route::get('/{id}/services', [CompanyServicesController::class, 'index'])
            ->name('services');
    });

    Route::prefix('/procurements')->name('procurements.')->group(function () {
        Route::get('/', [ProcurementsController::class, 'index'])
            ->name('get');
        Route::get('/compatible', [ProcurementsController::class, 'compatible'])
            ->name('compatible-companies');
        Route::get('/{id}', [ProcurementsController::class, 'show'])
            ->name('fetch');
        Route::get('/{id}/interested', [ProcurementsController::class, 'interested'])
            ->name('interested-companies');
        Route::post('/{id}/send-invitations', [ProcurementsController::class, 'sendInvitations'])
                ->name('fetch');
        Route::post('/', [ProcurementsController::class, 'create'])
            ->name('create');
        Route::put('/{id}', [ProcurementsController::class, 'update'])
            ->name('update');
    });

    Route::prefix('/company-infos')->name('company-infos.')->group(function () {
        Route::match(['PUT', 'PATCH'], '/', [CompanyInfoController::class, 'update'])
            ->name('update');
        Route::post('/{id}/status', [CompanyInfoController::class, 'changeStatus'])
            ->name('review');
        // Route::delete('/{id}', [FileController::class, 'destroy'])
            // ->middleware('auth:sanctum', 'verified')
            // ->name('delete');
        Route::get('/{id}', [CompanyInfoController::class, 'show'])
            ->name('fetch');
    });

    Route::prefix('/financial-infos')->name('financial-infos.')->group(function () {
        Route::match(['PUT', 'PATCH'], '/', [FinancialInfoController::class, 'update'])
            ->name('update');
        Route::post('/{id}/status', [FinancialInfoController::class, 'changeStatus'])
            ->name('review');
        // Route::delete('/{id}', [FileController::class, 'destroy'])
            // ->middleware('auth:sanctum', 'verified')
            // ->name('delete');
        Route::get('/{id}', [FinancialInfoController::class, 'show'])
            ->name('fetch');
    });

    Route::prefix('/company-standards')->name('company-standards.')->group(function () {
        Route::match(['PUT', 'PATCH'], '/', [CompanyStandardsController::class, 'update'])
            ->name('update');
        Route::post('/{id}/status', [CompanyStandardsController::class, 'changeStatus'])
            ->name('review');
        // Route::delete('/{id}', [FileController::class, 'destroy'])
            // ->middleware('auth:sanctum', 'verified')
            // ->name('delete');
        Route::get('/{id}', [CompanyStandardsController::class, 'show'])
            ->name('fetch');
    });

    Route::prefix('/company-services')->name('company-services.')->group(function () {
        Route::match(['PUT', 'PATCH'], '/', [CompanyServicesController::class, 'update'])
            ->name('update');
        Route::post('/{id}/status', [CompanyServicesController::class, 'changeStatus'])
            ->name('review');
        // Route::delete('/{id}', [FileController::class, 'destroy'])
            // ->middleware('auth:sanctum', 'verified')
            // ->name('delete');
        Route::get('/{id}', [CompanyServicesController::class, 'show'])
            ->name('fetch');
        Route::get('/', [CompanyServicesController::class, 'index'])
            ->name('get');
    });

    Route::prefix('/services')->name('services.')->group(function () {
        Route::get('/{id}', [ServicesController::class, 'show'])
            ->name('fetch');
        Route::get('/', [ServicesController::class, 'index'])
            ->name('get');
    });
    Route::prefix('/categories')->name('categories.')->group(function () {
        Route::get('/{id}', [CategoriesController::class, 'show'])
            ->name('fetch');
        Route::get('/', [CategoriesController::class, 'index'])
            ->name('get');
    });
    Route::prefix('/subcategories')->name('subcategories.')->group(function () {
        Route::get('/{id}', [SubcategoriesController::class, 'show'])
            ->name('fetch');
        Route::get('/', [SubcategoriesController::class, 'index'])
            ->name('get');
    });
});

