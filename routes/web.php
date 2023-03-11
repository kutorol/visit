<?php

declare(strict_types=1);

use App\GrpcClient\CategoryFixedItemServiceClientGrpcHelper;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// todo Переопределить пути, чтобы их отправить на view('app') и отловить в reactJS
// Оставляем пути, чтобы отправка ссылки на восстановление пароля работала
Auth::routes();

Route::fallback(function () {
    app(CategoryFixedItemServiceClientGrpcHelper::class)->do();
echo "<pre>";
print_r(['fasd']);
echo "</pre>";
exit;
    //    return view('app');
});
