<?php

use App\Http\Controllers\WEB;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::redirect('settings', '/settings/profile');

    Route::get('settings/profile', [WEB\Settings\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [WEB\Settings\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('settings/profile', [WEB\Settings\ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings/password', [WEB\Settings\PasswordController::class, 'edit'])->name('password.edit');

    Route::put('settings/password', [WEB\Settings\PasswordController::class, 'update'])
        ->middleware('throttle:6,1')
        ->name('password.update');

    Route::get('settings/appearance', function () {
        return Inertia::render('settings/appearance');
    })->name('appearance');
});
