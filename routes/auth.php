<?php

use App\Http\Controllers\WEB;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [WEB\Auth\RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [WEB\Auth\RegisteredUserController::class, 'store']);

    Route::get('login', [WEB\Auth\AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [WEB\Auth\AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [WEB\Auth\PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [WEB\Auth\PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [WEB\Auth\NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [WEB\Auth\NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', WEB\Auth\EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', WEB\Auth\VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [WEB\Auth\EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [WEB\Auth\ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [WEB\Auth\ConfirmablePasswordController::class, 'store'])
        ->middleware('throttle:6,1');

    Route::post('logout', [WEB\Auth\AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
