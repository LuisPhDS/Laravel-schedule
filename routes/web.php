<?php

use App\Http\Controllers\Login;
use App\Http\Controllers\Main;
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

/* ==================================== */
/* Logout */
/* ==================================== */
    Route::get('/logout', [Login::class, 'logout'])->name('logout');

/* ==================================== */
/* Home */
/* ==================================== */
    Route::get('/index', [Main::class, 'index'])->name('index');

// =================================
// Tarefa - criar
// =================================
    Route::get('/nova_tarefa', [Main::class, 'nova_tarefa'])->name('nova_tarefa');
    Route::post('/nova_tarefa_submit', [Main::class, 'nova_tarefa_submit'])->name('nova_tarefa_submit');

// =================================
// Tarefa - editar
// =================================
    Route::get('/editar_tarefa/{id}', [Main::class, 'editar_tarefa'])->name('editar_tarefa');
    Route::get('/editar_tarefa_subimit', [Main::class, 'editar_tarefa_subimit'])->name('editar_tarefa_subimit')->name('editar_tarefa_subimit');