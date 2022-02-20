<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdminController;

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



Route::middleware('auth:sanctum')->group(function () {
    Route::post('/profile', [UserController::class, 'update']);
    Route::post('admin/send-email', [ AdminController::class, 'sendInvitation'])->middleware('admin');
});


Route::post('accept/invitation', [UserController::class, 'acceptInvitation'])->name('user.accept.invitation');
Route::post('verify-otp', [UserController::class, 'register'])->name('user.register');
Route::post('login', [UserController::class, 'login'])->name('user.login');


