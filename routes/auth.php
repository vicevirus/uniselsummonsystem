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
use App\Http\Controllers\Auth\SecurityGuardController;
use App\Http\Controllers\Auth\AdminController;


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// Security Guard specific routes
Route::prefix('guard')->name('guard.')->group(function () {
    Route::middleware('guest:guard')->group(function () {
        Route::get('login', [SecurityGuardController::class, 'showLoginForm'])
            ->name('login');
        Route::post('login', [SecurityGuardController::class, 'login']);
        // If you have a guard registration system, add those routes here as well.
    });

    Route::middleware('auth:guard')->group(function () {
        Route::get('dashboard', [SecurityGuardController::class, 'dashboard'])
            ->name('dashboard');
        Route::post('logout', [SecurityGuardController::class, 'logout'])
            ->name('logout');
    });
});



Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login']);

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

        // Manage Students
        Route::get('/manage_students', [AdminController::class, 'manageStudent'])->name('manage_students');
        Route::get('/add_student', [AdminController::class, 'addStudent'])->name('add_student');
        Route::get('/edit_student/{matricNumber}', [AdminController::class, 'editStudent'])->name('edit_student');
        Route::get('/delete_student/{matricNumber}', [AdminController::class, 'deleteStudent'])->name('delete_student');


        //Edit student
        Route::put('/student/{matricNumber}/update', [AdminController::class, 'updateStudent'])->name('updateStudent');

        // Manage Summons
        Route::get('/manage_summons', [AdminController::class, 'manageSummons'])->name('manage_summons');

        // Register security guards account
        Route::get('/manage_guards', [AdminController::class, 'manageGuards'])->name('manage_guards');
        Route::get('/createGuard', [SecurityGuardController::class, 'createGuardForm']);
        Route::post('/storeGuard', [SecurityGuardController::class, 'storeGuard']);
    });
});

Route::get('registration-pending', function () {
    return view('auth.registrationPending');
})->name('registration.pending');

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
