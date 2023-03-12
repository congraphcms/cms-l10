<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Congraph\Eav\AttributesController;
use Congraph\Eav\Commands\Entities\EntityDeleteCommand;
use Congraph\Eav\Commands\Entities\EntityGetCommand;
use Congraph\Core\Exceptions\BadRequestException;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\ClientApp\FileController;
use App\Http\Controllers\ClientApp\FileServeController;
use App\Http\Controllers\ClientApp\CompanyInfoController;
use App\Http\Controllers\ClientApp\FinancialInfoController;
use App\Http\Controllers\ClientApp\CompanyStandardsController;
use App\Http\Controllers\ClientApp\ServicesController;
use App\Http\Controllers\ClientApp\ContactController;
use App\Http\Controllers\ClientApp\AnualReportController;
use App\Http\Controllers\ClientApp\AddressController;
use App\Http\Controllers\ClientApp\ContentController;
use App\Http\Controllers\ClientApp\EOIController;
use App\Http\Controllers\ClientApp\HSEController;
use App\Http\Controllers\ClientApp\InsuranceController;
use App\Http\Controllers\ClientApp\InterestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum', 'password.confirm')->delete('/user', function (Request $request) {


    $user = $request->user();

    // GET RELATED ENTITIES
    $bus = App::make('Congraph\Core\Bus\CommandDispatcher');
    $command = App::make(EntityGetCommand::class);
    $params = [
        'filter' => [
            'fields.owner_id' => $user->id
        ]
    ];
    $command->setParams($params);
    $result = $bus->dispatch($command);
    foreach ($result as $key => $entity) {
        // DELETE ENTITY
        $command = App::make(EntityDeleteCommand::class);
        $command->setId($entity->id);
        $deleted = $bus->dispatch($command);
    }
    return $user->delete();
});

Route::post('/set-locale', function (Request $request) {
    $request->validate([
        'locale' => 'required|in:sr_RS,en_US'
    ]);

    return response(null)->cookie('locale', $request->input('locale'));
});

Route::prefix('/data')->name('ClientApp.')->group(function () {
    Route::prefix('/content')->name('content.')->group(function () {
        Route::get('/', [ContentController::class, 'index'])
            ->name('get');
        Route::get('/{id}', [ContentController::class, 'show'])
            ->name('fetch');
    });
    Route::prefix('/eoi')->name('eoi.')->group(function () {
        Route::get('/', [EOIController::class, 'index'])
            ->middleware('auth:sanctum', 'verified')
            ->name('get');
        Route::get('/{id}', [EOIController::class, 'show'])
            ->middleware('auth:sanctum', 'verified')
            ->name('fetch');
    });
    Route::prefix('/files')->name('file.')->group(function () {
        Route::post('/', [FileController::class, 'store'])
            ->middleware('auth:sanctum', 'verified')
            ->name('create');
        Route::delete('/{id}', [FileController::class, 'destroy'])
            ->middleware('auth:sanctum', 'verified')
            ->name('delete');
        Route::get('/{id}', [FileController::class, 'show'])
            ->middleware('auth:sanctum', 'verified')
            ->where('id', '[0-9]+')
            ->name('fetch');
        Route::get('/{file}', [FileServeController::class, 'index'])
            ->middleware('auth:sanctum', 'verified')
            ->name('serve');
    });
    Route::prefix('/company-info')->name('company-info.')->group(function () {
        Route::match(['PUT', 'PATCH'], '/', [CompanyInfoController::class, 'update'])
            ->middleware('auth:sanctum', 'verified')
            ->name('update');
        Route::post('/request-review', [CompanyInfoController::class, 'requestReview'])
            ->middleware('auth:sanctum', 'verified')
            ->name('review');
        Route::post('/unlock', [CompanyInfoController::class, 'unlock'])
            ->middleware('auth:sanctum', 'verified')
            ->name('unlock');
        // Route::delete('/{id}', [FileController::class, 'destroy'])
            // ->middleware('auth:sanctum', 'verified')
            // ->name('delete');
        Route::get('/', [CompanyInfoController::class, 'show'])
            ->middleware('auth:sanctum', 'verified')
            ->name('fetch');
    });
    Route::prefix('/financial-info')->name('financial-info.')->group(function () {
        Route::match(['PUT', 'PATCH'], '/', [FinancialInfoController::class, 'update'])
            ->middleware('auth:sanctum', 'verified')
            ->name('update');
        Route::post('/request-review', [FinancialInfoController::class, 'requestReview'])
            ->middleware('auth:sanctum', 'verified')
            ->name('review');
        Route::post('/unlock', [FinancialInfoController::class, 'unlock'])
            ->middleware('auth:sanctum', 'verified')
            ->name('unlock');
        // Route::delete('/{id}', [FileController::class, 'destroy'])
            // ->middleware('auth:sanctum', 'verified')
            // ->name('delete');
        Route::get('/', [FinancialInfoController::class, 'show'])
            ->middleware('auth:sanctum', 'verified')
            ->name('fetch');
    });
    Route::prefix('/company-standards')->name('company-standards.')->group(function () {
        Route::match(['PUT', 'PATCH'], '/', [CompanyStandardsController::class, 'update'])
            ->middleware('auth:sanctum', 'verified')
            ->name('update');
        Route::post('/request-review', [CompanyStandardsController::class, 'requestReview'])
            ->middleware('auth:sanctum', 'verified')
            ->name('review');
        Route::post('/unlock', [CompanyStandardsController::class, 'unlock'])
            ->middleware('auth:sanctum', 'verified')
            ->name('unlock');
        // Route::delete('/{id}', [FileController::class, 'destroy'])
            // ->middleware('auth:sanctum', 'verified')
            // ->name('delete');
        Route::get('/', [CompanyStandardsController::class, 'show'])
            ->middleware('auth:sanctum', 'verified')
            ->name('fetch');
    });
    Route::prefix('/company-services')->name('company-service.')->group(function () {
        Route::post('/{serviceId}', [ServicesController::class, 'create'])
            ->middleware('auth:sanctum', 'verified')
            ->name('create');
        Route::delete('/{id}', [ServicesController::class, 'destroy'])
            ->middleware('auth:sanctum', 'verified')
            ->name('delete');
        Route::get('/', [ServicesController::class, 'index'])
            ->middleware('auth:sanctum', 'verified')
            ->name('get');
        Route::get('/services', [ServicesController::class, 'services'])
            ->middleware('auth:sanctum', 'verified')
            ->name('services');
        Route::get('/categories', [ServicesController::class, 'categories'])
            ->middleware('auth:sanctum', 'verified')
            ->name('categories');
        Route::get('/subcategories', [ServicesController::class, 'subcategories'])
            ->middleware('auth:sanctum', 'verified')
            ->name('subcategories');
    });
    // Route::prefix('/company-hse')->name('company-hse.')->group(function () {
    //     Route::match(['PUT', 'PATCH'], '/', [HSEController::class, 'update'])
    //         ->middleware('auth:sanctum', 'verified')
    //         ->name('update');
    //     Route::post('/request-review', [HSEController::class, 'requestReview'])
    //         ->middleware('auth:sanctum', 'verified')
    //         ->name('review');
    //     Route::post('/unlock', [HSEController::class, 'unlock'])
    //         ->middleware('auth:sanctum', 'verified')
    //         ->name('unlock');
    //     // Route::delete('/{id}', [FileController::class, 'destroy'])
    //         // ->middleware('auth:sanctum', 'verified')
    //         // ->name('delete');
    //     Route::get('/', [HSEController::class, 'show'])
    //         ->middleware('auth:sanctum', 'verified')
    //         ->name('fetch');
    // });
    Route::prefix('/contact')->name('contact.')->group(function () {
        Route::post('/', [ContactController::class, 'create'])
            ->middleware('auth:sanctum', 'verified')
            ->name('create');
        Route::match(['PUT', 'PATCH'], '/{id}', [ContactController::class, 'update'])
            ->middleware('auth:sanctum', 'verified')
            ->name('update');
        Route::delete('/{id}', [ContactController::class, 'destroy'])
            ->middleware('auth:sanctum', 'verified')
            ->name('delete');
        // Route::delete('/{id}', [FileController::class, 'destroy'])
            // ->middleware('auth:sanctum', 'verified')
            // ->name('delete');
        Route::get('/{id}', [ContactController::class, 'show'])
            ->middleware('auth:sanctum', 'verified')
            ->name('fetch');
    });
    Route::prefix('/anual-report')->name('anual-report.')->group(function () {
        Route::post('/', [AnualReportController::class, 'create'])
            ->middleware('auth:sanctum', 'verified')
            ->name('create');
        Route::match(['PUT', 'PATCH'], '/{id}', [AnualReportController::class, 'update'])
            ->middleware('auth:sanctum', 'verified')
            ->name('update');
        Route::delete('/{id}', [AnualReportController::class, 'destroy'])
            ->middleware('auth:sanctum', 'verified')
            ->name('delete');
        // Route::delete('/{id}', [FileController::class, 'destroy'])
            // ->middleware('auth:sanctum', 'verified')
            // ->name('delete');
        Route::get('/{id}', [AnualReportController::class, 'show'])
            ->middleware('auth:sanctum', 'verified')
            ->name('fetch');
    });
    Route::prefix('/address')->name('address.')->group(function () {
        Route::post('/', [AddressController::class, 'create'])
            ->middleware('auth:sanctum', 'verified')
            ->name('create');
        Route::match(['PUT', 'PATCH'], '/{id}', [AddressController::class, 'update'])
            ->middleware('auth:sanctum', 'verified')
            ->name('update');
        Route::delete('/{id}', [AddressController::class, 'destroy'])
            ->middleware('auth:sanctum', 'verified')
            ->name('delete');
        // Route::delete('/{id}', [FileController::class, 'destroy'])
            // ->middleware('auth:sanctum', 'verified')
            // ->name('delete');
        Route::get('/{id}', [AddressController::class, 'show'])
            ->middleware('auth:sanctum', 'verified')
            ->name('fetch');
    });
    Route::prefix('/insurance')->name('insurance.')->group(function () {
        Route::post('/', [InsuranceController::class, 'create'])
            ->middleware('auth:sanctum', 'verified')
            ->name('create');
        Route::match(['PUT', 'PATCH'], '/{id}', [InsuranceController::class, 'update'])
            ->middleware('auth:sanctum', 'verified')
            ->name('update');
        Route::delete('/{id}', [InsuranceController::class, 'destroy'])
            ->middleware('auth:sanctum', 'verified')
            ->name('delete');
        // Route::delete('/{id}', [FileController::class, 'destroy'])
            // ->middleware('auth:sanctum', 'verified')
            // ->name('delete');
        Route::get('/{id}', [InsuranceController::class, 'show'])
            ->middleware('auth:sanctum', 'verified')
            ->name('fetch');
    });
    Route::prefix('/interest')->name('interest.')->group(function () {
        Route::post('/', [InterestController::class, 'create'])
            ->middleware('auth:sanctum', 'verified')
            ->name('create');
        Route::delete('/{id}', [InterestController::class, 'destroy'])
            ->middleware('auth:sanctum', 'verified')
            ->name('delete');
        // Route::delete('/{id}', [FileController::class, 'destroy'])
            // ->middleware('auth:sanctum', 'verified')
            // ->name('delete');
        Route::get('/{id}', [InterestController::class, 'show'])
            ->middleware('auth:sanctum', 'verified')
            ->name('fetch');
    });
});
