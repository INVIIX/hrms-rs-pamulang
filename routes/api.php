<?php
use App\Http\Controllers\API;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'api.'
], function () {
    Route::group([
        'middleware' => ['guest']
    ], function () {
        Route::post('login', [API\AuthController::class, 'login'])->name('auth.login');
    });

    Route::group([
        'middleware' => ['auth:api']
    ], function () {
        Route::get('me', [API\AuthController::class, 'me'])->name('auth.me');
        Route::post('logout', [API\AuthController::class, 'logout'])->name('auth.logout');

        Route::prefix('enums')->name('enums.')->group(function () {
            Route::get('/', [API\EnumReferenceController::class, 'index'])->name('all');
            Route::get('/citizenship', [API\EnumReferenceController::class, 'show'])->name('citizenship');
            Route::get('/degree', [API\EnumReferenceController::class, 'show'])->name('degree');
            Route::get('/employee-status', [API\EnumReferenceController::class, 'show'])->name('employee-status');
            Route::get('/employee-type', [API\EnumReferenceController::class, 'show'])->name('employee-type');
            Route::get('/gender', [API\EnumReferenceController::class, 'show'])->name('gender');
            Route::get('/leave-unit-type', [API\EnumReferenceController::class, 'show'])->name('leave-unit-type');
            Route::get('/marital-status', [API\EnumReferenceController::class, 'show'])->name('marital-status');
            Route::get('/relationship', [API\EnumReferenceController::class, 'show'])->name('relationship');
            Route::get('/religion', [API\EnumReferenceController::class, 'show'])->name('religion');
            Route::get('/salary-component-type', [API\EnumReferenceController::class, 'show'])->name('salary-component-type');
            Route::get('/document-collection', [API\EnumReferenceController::class, 'show'])->name('document-collection');
        });

        Route::get('groups/tree', [API\GroupController::class, 'tree'])->name('groups.tree');
        Route::apiResource('groups', API\GroupController::class);
        Route::apiResource('positions', API\PositionController::class);
        Route::apiResource('salary-components', API\SalaryComponentController::class);
        Route::apiResource('employees', API\EmployeeController::class);
        Route::apiResource('employees.employments', API\EmployeeEmploymentController::class);
        Route::apiResource('employees.educational-backgrounds', API\EmployeeEducationalBackgroundController::class);
        Route::apiResource('employees.trainings', API\EmployeeTrainingController::class);
        Route::post('employees/{employee}/salary-components/batch', [API\EmployeeSalaryComponentController::class, 'batchStore'])->name('employees.salary-components.batch.store');
        Route::apiResource('employees.salary-components', API\EmployeeSalaryComponentController::class);
        Route::apiResource('employees.contacts', API\EmployeeContactController::class);
        Route::apiResource('employees.documents', API\EmployeeDocumentController::class);

        Route::apiResource('work-schedules', API\WorkScheduleController::class);
    });
});
