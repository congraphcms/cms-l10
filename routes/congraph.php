<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Congraph\Eav\AttributesController;




// OLD Congraph
Route::prefix('api/v1')->name('CB.')->group(function () {

    // Attributes
    Route::prefix('attributes')->name('attribute.')->group(function () {
        // Create
        Route::post('/', [App\Http\Controllers\Congraph\Eav\AttributeController::class, 'store'])
            ->name('create')
            ->middleware(['auth:congraphapi', 'permission:manage_content_model']);
        // Update
        Route::match(['PUT', 'PATCH'], '/{id}', [App\Http\Controllers\Congraph\Eav\AttributeController::class, 'update'])
            ->name('update')
            ->middleware(['auth:congraphapi', 'permission:manage_content_model']);
        // Delete
        Route::delete('/{id}', [App\Http\Controllers\Congraph\Eav\AttributeController::class, 'destroy'] )
            ->name('delete')
            ->middleware(['auth:congraphapi', 'permission:manage_content_model']);
        // Get
        Route::get('/', [ App\Http\Controllers\Congraph\Eav\AttributeController::class, 'index'])
            ->name('get')
            ->middleware(['auth:congraphapi', 'permission:read_content_model']);
        // Fetch
        Route::get('/{id}', [App\Http\Controllers\Congraph\Eav\AttributeController::class, 'show'])
            ->name('fetch')
            ->middleware(['auth:congraphapi', 'permission:read_content_model']);

    });

    // Attribute Sets
    Route::prefix('attribute-sets')->name('attribute-set.')->group(function () {
        // Create
        Route::post('/', [App\Http\Controllers\Congraph\Eav\AttributeSetController::class, 'store'])
            ->name('create')
            ->middleware(['auth:congraphapi', 'permission:manage_content_model']);
        // Update
        Route::match(['PUT', 'PATCH'], '/{id}', [App\Http\Controllers\Congraph\Eav\AttributeSetController::class, 'update'])
            ->name('update')
            ->middleware(['auth:congraphapi', 'permission:manage_content_model']);
        // Delete
        Route::delete('/{id}', [App\Http\Controllers\Congraph\Eav\AttributeSetController::class, 'destroy'] )
            ->name('delete')
            ->middleware(['auth:congraphapi', 'permission:manage_content_model']);
        // Get
        Route::get('/', [ App\Http\Controllers\Congraph\Eav\AttributeSetController::class, 'index'])
            ->name('get')
            ->middleware(['auth:congraphapi', 'permission:read_content_model']);
        // Fetch
        Route::get('/{id}', [App\Http\Controllers\Congraph\Eav\AttributeSetController::class, 'show'])
            ->name('fetch')
            ->middleware(['auth:congraphapi', 'permission:read_content_model']);

    });

    // Entity Types
    Route::prefix('entity-types')->name('entity-type.')->group(function () {
        // Create
        Route::post('/', [App\Http\Controllers\Congraph\Eav\EntityTypeController::class, 'store'])
            ->name('create')
            ->middleware(['auth:congraphapi', 'permission:manage_content_model']);
        // Update
        Route::match(['PUT', 'PATCH'], '/{id}', [App\Http\Controllers\Congraph\Eav\EntityTypeController::class, 'update'])
            ->name('update')
            ->middleware(['auth:congraphapi', 'permission:manage_content_model']);
        // Delete
        Route::delete('/{id}', [App\Http\Controllers\Congraph\Eav\EntityTypeController::class, 'destroy'] )
            ->name('delete')
            ->middleware(['auth:congraphapi', 'permission:manage_content_model']);
        // Get
        Route::get('/', [ App\Http\Controllers\Congraph\Eav\EntityTypeController::class, 'index'])
            ->name('get')
            ->middleware(['auth:congraphapi', 'permission:read_content_model']);
        // Fetch
        Route::get('/{id}', [App\Http\Controllers\Congraph\Eav\EntityTypeController::class, 'show'])
            ->name('fetch')
            ->middleware(['auth:congraphapi', 'permission:read_content_model']);

    });

    // Entities
    Route::prefix('entities')->name('entity.')->group(function () {
        // Create
        Route::post('/', [App\Http\Controllers\Congraph\Eav\EntityController::class, 'store'])
            ->name('create')
            ->middleware(['auth:congraphapi', 'permission:manage_content']);
        // Update
        Route::match(['PUT', 'PATCH'], '/{id}', [App\Http\Controllers\Congraph\Eav\EntityController::class, 'update'])
            ->name('update')
            ->middleware(['auth:congraphapi', 'permission:manage_content']);
        // Delete
        Route::delete('/{id}', [App\Http\Controllers\Congraph\Eav\EntityController::class, 'destroy'] )
            ->name('delete')
            ->middleware(['auth:congraphapi', 'permission:manage_content']);
        // Get
        Route::get('/', [ App\Http\Controllers\Congraph\Eav\EntityController::class, 'index'])
            ->name('get')
            ->middleware(['auth:congraphapi', 'permission:read_content']);
        // Fetch
        Route::get('/{id}', [App\Http\Controllers\Congraph\Eav\EntityController::class, 'show'])
            ->name('fetch')
            ->middleware(['auth:congraphapi', 'permission:read_content']);

    });

    // Files
    Route::prefix('files')->name('file.')->group(function () {
        // Create
        Route::post('/', [App\Http\Controllers\Congraph\Filesystem\FileController::class, 'store'])
            ->name('create')
            ->middleware(['auth:congraphapi', 'permission:manage_content']);
        // Update
        Route::match(['PUT', 'PATCH'], '/{id}', [App\Http\Controllers\Congraph\Filesystem\FileController::class, 'update'])
            ->name('update')
            ->middleware(['auth:congraphapi', 'permission:manage_content']);
        // Delete
        Route::delete('/{id}', [App\Http\Controllers\Congraph\Filesystem\FileController::class, 'destroy'] )
            ->name('delete')
            ->middleware(['auth:congraphapi', 'permission:manage_content']);
        // Get
        Route::get('/', [ App\Http\Controllers\Congraph\Filesystem\FileController::class, 'index'])
            ->name('get')
            ->middleware(['auth:congraphapi', 'permission:read_content']);
        // Fetch
        Route::get('/{id}', [App\Http\Controllers\Congraph\Filesystem\FileController::class, 'show'])
            ->name('fetch')
            ->where('id', '[0-9]+')
            ->middleware(['auth:congraphapi', 'permission:read_content']);

        // Serve
        Route::get('/{file}', [App\Http\Controllers\Congraph\Filesystem\FileServeController::class, 'index'])
            ->name('serve')
            ->middleware(['auth:congraphapi', 'permission:read_content']);

    });

    // Locales
    Route::prefix('locales')->name('locale.')->group(function () {
        // Create
        Route::post('/', [App\Http\Controllers\Congraph\Locales\LocaleController::class, 'store'])
            ->name('create')
            ->middleware(['auth:congraphapi', 'permission:manage_content_model']);
        // Update
        Route::match(['PUT', 'PATCH'], '/{id}', [App\Http\Controllers\Congraph\Locales\LocaleController::class, 'update'])
            ->name('update')
            ->middleware(['auth:congraphapi', 'permission:manage_content_model']);
        // Delete
        Route::delete('/{id}', [App\Http\Controllers\Congraph\Locales\LocaleController::class, 'destroy'] )
            ->name('delete')
            ->middleware(['auth:congraphapi', 'permission:manage_content_model']);
        // Get
        Route::get('/', [ App\Http\Controllers\Congraph\Locales\LocaleController::class, 'index'])
            ->name('get')
            ->middleware(['auth:congraphapi', 'permission:read_content_model']);
        // Fetch
        Route::get('/{id}', [App\Http\Controllers\Congraph\Locales\LocaleController::class, 'show'])
            ->name('fetch')
            ->middleware(['auth:congraphapi', 'permission:read_content_model']);

    });

    // Workflows
    Route::prefix('workflows')->name('workflow.')->group(function () {
        // Create
        Route::post('/', [App\Http\Controllers\Congraph\Workflows\WorkflowController::class, 'store'])
            ->name('create')
            ->middleware(['auth:congraphapi', 'permission:manage_content_model']);
        // Update
        Route::match(['PUT', 'PATCH'], '/{id}', [App\Http\Controllers\Congraph\Workflows\WorkflowController::class, 'update'])
            ->name('update')
            ->middleware(['auth:congraphapi', 'permission:manage_content_model']);
        // Delete
        Route::delete('/{id}', [App\Http\Controllers\Congraph\Workflows\WorkflowController::class, 'destroy'] )
            ->name('delete')
            ->middleware(['auth:congraphapi', 'permission:manage_content_model']);
        // Get
        Route::get('/', [ App\Http\Controllers\Congraph\Workflows\WorkflowController::class, 'index'])
            ->name('get')
            ->middleware(['auth:congraphapi', 'permission:read_content_model']);
        // Fetch
        Route::get('/{id}', [App\Http\Controllers\Congraph\Workflows\WorkflowController::class, 'show'])
            ->name('fetch')
            ->middleware(['auth:congraphapi', 'permission:read_content_model']);

    });

    // Workflow points
    Route::prefix('workflow-points')->name('workflow-point.')->group(function () {
        // Create
        Route::post('/', [App\Http\Controllers\Congraph\Workflows\WorkflowPointController::class, 'store'])
            ->name('create')
            ->middleware(['auth:congraphapi', 'permission:manage_content_model']);
        // Update
        Route::match(['PUT', 'PATCH'], '/{id}', [App\Http\Controllers\Congraph\Workflows\WorkflowPointController::class, 'update'])
            ->name('update')
            ->middleware(['auth:congraphapi', 'permission:manage_content_model']);
        // Delete
        Route::delete('/{id}', [App\Http\Controllers\Congraph\Workflows\WorkflowPointController::class, 'destroy'] )
            ->name('delete')
            ->middleware(['auth:congraphapi', 'permission:manage_content_model']);
        // Get
        Route::get('/', [ App\Http\Controllers\Congraph\Workflows\WorkflowPointController::class, 'index'])
            ->name('get')
            ->middleware(['auth:congraphapi', 'permission:read_content_model']);
        // Fetch
        Route::get('/{id}', [App\Http\Controllers\Congraph\Workflows\WorkflowPointController::class, 'show'])
            ->name('fetch')
            ->middleware(['auth:congraphapi', 'permission:read_content_model']);

    });

    // Users
    Route::prefix('users')->name('user.')->group(function () {
        // Create
        Route::post('/', [App\Http\Controllers\Congraph\Auth\UserController::class, 'store'])
            ->name('create')
            ->middleware(['auth:congraphapi', 'permission:manage_users']);
        // Update
        Route::match(['PUT', 'PATCH'], '/{id}', [App\Http\Controllers\Congraph\Auth\UserController::class, 'update'])
            ->name('update')
            ->middleware(['auth:congraphapi', 'permission:manage_users']);
        // Delete
        Route::delete('/{id}', [App\Http\Controllers\Congraph\Auth\UserController::class, 'destroy'] )
            ->name('delete')
            ->middleware(['auth:congraphapi', 'permission:manage_users']);
        // Get
        Route::get('/', [ App\Http\Controllers\Congraph\Auth\UserController::class, 'index'])
            ->name('get')
            ->middleware(['auth:congraphapi', 'permission:read_users']);
        // Fetch self
        Route::get('/me', [App\Http\Controllers\Congraph\Auth\UserController::class, 'showSelf'])
            ->name('self')
            ->middleware(['auth:congraphapi']);
        // Fetch
        Route::get('/{id}', [App\Http\Controllers\Congraph\Auth\UserController::class, 'show'])
            ->name('fetch')
            ->middleware(['auth:congraphapi', 'permission:read_users']);
        // Change own password
        Route::get('/me/change-password', [App\Http\Controllers\Congraph\Auth\UserController::class, 'changeOwnPassword'])
            ->name('changeOwnPassword')
            ->middleware(['auth:congraphapi']);
        // Change user's password
        Route::get('/{id}/change-password', [App\Http\Controllers\Congraph\Auth\UserController::class, 'changePassword'])
            ->name('changePassword')
            ->middleware(['auth:congraphapi', 'permission:manage_users']);
    });

    // Roles
    Route::prefix('roles')->name('role.')->group(function () {
        // Create
        Route::post('/', [App\Http\Controllers\Congraph\Auth\RoleController::class, 'store'])
            ->name('create')
            ->middleware(['auth:congraphapi', 'permission:manage_roles']);
        // Update
        Route::match(['PUT', 'PATCH'], '/{id}', [App\Http\Controllers\Congraph\Auth\RoleController::class, 'update'])
            ->name('update')
            ->middleware(['auth:congraphapi', 'permission:manage_roles']);
        // Delete
        Route::delete('/{id}', [App\Http\Controllers\Congraph\Auth\RoleController::class, 'destroy'] )
            ->name('delete')
            ->middleware(['auth:congraphapi', 'permission:manage_roles']);
        // Get
        Route::get('/', [ App\Http\Controllers\Congraph\Auth\RoleController::class, 'index'])
            ->name('get')
            ->middleware(['auth:congraphapi', 'permission:read_roles']);
        // Fetch
        Route::get('/{id}', [App\Http\Controllers\Congraph\Auth\RoleController::class, 'show'])
            ->name('fetch')
            ->middleware(['auth:congraphapi', 'permission:read_roles']);

    });

    // Clients
    Route::prefix('clients')->name('client.')->group(function () {
        // Create
        Route::post('/', [App\Http\Controllers\Congraph\Auth\ClientController::class, 'store'])
            ->name('create')
            ->middleware(['auth:congraphapi', 'permission:manage_clients']);
        // Update
        Route::match(['PUT', 'PATCH'], '/{id}', [App\Http\Controllers\Congraph\Auth\ClientController::class, 'update'])
            ->name('update')
            ->middleware(['auth:congraphapi', 'permission:manage_clients']);
        // Delete
        Route::delete('/{id}', [App\Http\Controllers\Congraph\Auth\ClientController::class, 'destroy'] )
            ->name('delete')
            ->middleware(['auth:congraphapi', 'permission:manage_clients']);
        // Get
        Route::get('/', [ App\Http\Controllers\Congraph\Auth\ClientController::class, 'index'])
            ->name('get')
            ->middleware(['auth:congraphapi', 'permission:read_clients']);
        // Fetch
        Route::get('/{id}', [App\Http\Controllers\Congraph\Auth\ClientController::class, 'show'])
            ->name('fetch')
            ->middleware(['auth:congraphapi', 'permission:read_clients']);

    });
});

Route::get('oauth/owner', function() {
    return response()->json(['data' => Auth::user()], 200);
})->middleware('auth:congraphapi');

// Route::get('testrole', function() {
//     Auth::user()->assignRole('SuperAdmin');
//     return 'OK';
// })->middleware('auth:congraphapi');
