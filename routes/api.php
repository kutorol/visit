<?php

declare(strict_types=1);

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForgotController;
use App\Http\Controllers\Api\List\ListController;
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
Route::middleware(['auth:api', 'manager'])->prefix('/list')->group(function (){
    Route::get("/users", [ListController::class, 'find'])->name("api.list_users");
});

/* ========== Конец списка юзеров ========== */
