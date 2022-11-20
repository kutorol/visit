<?php

declare(strict_types=1);

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForgotController;
use App\Http\Controllers\Api\User\GateUserController;
use App\Http\Controllers\Api\User\InfoUserController;
use App\Http\Controllers\Api\User\ListController;
use App\Http\Controllers\Api\User\ManageUserController;
use Illuminate\Support\Facades\Route;

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

/* ======= Регистрация ========= */
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
});

Route::prefix('/password')->group(function () {
    // отправляем ссылку на восстановление пароля
    Route::post('forgot-password', [ForgotController::class, 'forgot'])->name('api.pass_forgot');
    // восстанавливаем пароль по ссылке
    Route::post('reset/{token}', [ForgotController::class, 'reset'])->name('api.pass_reset');
});

/* ======= Конец регистрация ========= */

/* ========== Список юзеров ========== */
Route::middleware(['auth:api', 'manager'])->prefix('/users')->group(function () {
    Route::get('', [ListController::class, 'find'])->name('api.list_users');
    Route::get('/search', [ListController::class, 'search'])->name('api.search_list_users');
});

/* ========== Конец списка юзеров ========== */

Route::middleware(['auth:api'])->prefix('/user')->group(function () {
    Route::middleware('editor')->group(function (){
        Route::post('', [ManageUserController::class, 'create'])->name('api.create_user');
        Route::delete('', [ManageUserController::class, 'delete'])->name('api.delete_user');
    });

    Route::middleware('manager')->group(function (){
        // only user info
        Route::get('/{id}', [InfoUserController::class, 'info'])->name('api.info_users');
        // user info with actions
        Route::get('/{id}/full', [GateUserController::class, 'info'])->name('api.full_info_users');
    });
});
