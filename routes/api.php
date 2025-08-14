<?php
use App\Http\Controllers\API;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'api.'
], function () {
    Route::group([
        'middleware' => ['guest']
    ], function () {
        Route::prefix('enums')->name('enums.')->group(function(){
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
        });
        Route::post('login', [API\AuthController::class, 'login'])->name('auth.login');
    });

    Route::group([
        'middleware' => ['auth:api']
    ], function () {
        Route::post('logout', [API\AuthController::class, 'logout'])->name('auth.logout');
        Route::apiResource('employees', App\Http\Controllers\API\EmployeeController::class);
        Route::apiResource('employees.educational-backgrounds', App\Http\Controllers\API\EmployeeEducationalBackgroundController::class);
    });
});


