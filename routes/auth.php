<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

/**
 * Authentication routes for user registration, login, password reset, email verification, 
 * and password confirmation.
 *
 * This group contains routes for user authentication, including actions for registering, 
 * logging in, resetting passwords, confirming email addresses, and managing passwords.
 */

// Guest routes (for unauthenticated users)
Route::middleware('guest')->group(function () {
    // Register user
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register'); // Show registration form

    Route::post('register', [RegisteredUserController::class, 'store']); // Store new user data

    // Login user
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login'); // Show login form

    Route::post('login', [AuthenticatedSessionController::class, 'store']); // Handle user login

    // Forgot password
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request'); // Show password reset request form

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email'); // Send password reset email

    // Reset password
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset'); // Show password reset form with token

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store'); // Store the new password
});

// Authenticated routes (for authenticated users)
Route::middleware('auth')->group(function () {
    // Email verification prompt
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice'); // Show email verification prompt

    // Verify email with signed URL
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1']) // Signed and throttled verification link
        ->name('verification.verify'); // Handle email verification

    // Resend verification email
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1') // Throttle the number of resend attempts
        ->name('verification.send'); // Send email verification notification

    // Confirm password before updating
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm'); // Show confirm password form

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']); // Confirm password action

    // Update password
    Route::put('password', [PasswordController::class, 'update'])->name('password.update'); // Handle password update

    // Logout user
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout'); // Logout user and invalidate session
});
