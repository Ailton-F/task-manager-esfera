<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    $user = Auth::user();
    if(!$user){
        return redirect(route('auth.index'));
    }
    return redirect(route('tasks.index'));
});


Route::prefix('auth')->group(function(){
    Route::get('/',[AuthController::class, 'index'])->name('auth.index');
    
    Route::get('/forgot-password', [AuthController::class, 'forgot_password'])->name('auth.forgot_password');
    Route::get('/new-password/{token}', [AuthController::class, 'new_password'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'reset_password'])->name('auth.reset_password');
    Route::post('/send-token', [AuthController::class, 'send_reset_token'])->name('auth.send_token');

    Route::post('/login',[AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout',[AuthController::class, 'logout'])->name('auth.logout')->middleware(['auth:sanctum']);
});

Route::prefix('email')->group(function(){
    Route::get('/verify', [EmailController::class, 'show'])->name('verification.notice');
    
    Route::get('/verify/{id}/{hash}', [EmailController::class, 'verify'])
        // ->middleware(['signed'])
        ->name('verification.verify');

    Route::post('/verification-notify', [EmailController::class, 'send'])
        // ->middleware(['throttle:6,1']);
        ->name('verification.send');
});

Route::resource('users', UserController::class);
Route::resource('tasks', TaskController::class)->middleware(['auth:sanctum']);