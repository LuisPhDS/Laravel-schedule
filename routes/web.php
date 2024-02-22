<?php

use App\Http\Controllers\Login;
use Illuminate\Support\Facades\Route;

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
/* ==================================== */
/* Login */
/* ==================================== */
Route::get('/', [Login::class, 'login'])->name('login');
Route::post('/login_submit', [Login::class, 'login_submit'])->name('login_submit');
