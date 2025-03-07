<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin/home', function(){
    return view('admin.layout');
});

Route::get('/admin/account', [AccountController::class, 'index']);
Route::get('/admin/account/{id}', [AccountController::class, 'show'])->name('admin.account');
Route::post('/admin/account', [AccountController::class, 'store'])->name('admin.account.store');
Route::put('/admin/account/{id}', [AccountController::class, 'update'])->name('admin.account.update'); // Thêm route này
Route::delete('/admin/account/{id}', [AccountController::class, 'destroy'])->name('admin.account.destroy');

