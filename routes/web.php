<?php

use App\Http\Controllers\Login;
use App\Http\Controllers\Main;
use App\Http\Controllers\Contato;
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

// ROTA COM MIDDLEWARE / Fora da aplicação
Route::middleware('CheckLogout')->group(function(){
    /* ==================================== */
    /* Login */
    /* ==================================== */
        Route::get('/', [Login::class, 'login'])->name('login');
        Route::post('/login_submit', [Login::class, 'login_submit'])->name('login_submit');

    /* ==================================== */
    /* Usuário */
    /* ==================================== */
        Route::get('/signin', [Login::class, 'signin'])->name('signin');
        Route::post('/novo_usuario_submit', [Login::class, 'novo_usuario_submit'])->name('novo_usuario_submit');
});


// ROTA COM MIDDLEWARE / Dentro da aplicação
Route::middleware('CheckLogin')->group(function(){
    // =================================
    //              TAREFA
    // =================================
        /* ================================= */
        // listar
        /* ================================= */
        Route::get('/index', [Main::class, 'index'])->name('index');

        // =================================
        // criar
            Route::get('/nova_tarefa', [Main::class, 'nova_tarefa'])->name('nova_tarefa');
            Route::post('/nova_tarefa_submit', [Main::class, 'nova_tarefa_submit'])->name('nova_tarefa_submit');

        // =================================
        //  editar
            Route::get('/editar_tarefa/{id}', [Main::class, 'editar_tarefa'])->name('editar_tarefa');
            Route::post('/editar_tarefa_subimit', [Main::class, 'editar_tarefa_subimit'])->name('editar_tarefa_subimit');

        // =================================
        // excluir
            Route::get('/excluir_tarefa/{id}', [Main::class, 'excluir_tarefa'])->name('excluir_tarefa');
            Route::get('/excluir_tarefa_confirmar/{id}', [Main::class, 'excluir_tarefa_confirmar'])->name('excluir_tarefa_confirmar');
        // =================================
        // filtro
        Route::post('/filtro/{filtro}', [Main::class, 'filtro'])->name('filtro');


    /* ==================================== */
    /* Logout */
    /* ==================================== */
        Route::get('/logout', [Login::class, 'logout'])->name('logout');

    });

    // =================================
    //            CONTATOS
    // =================================
        // listar
            Route::get('/contatos', [Contato::class, 'contatos'])->name('contatos');

        // criar
            Route::get('/novo_contato', [Contato::class, 'novo_contato'])->name('novo_contato');
            Route::post('/novo_contato_submit', [Contato::class, 'novo_contato_submit'])->name('novo_contato_submit');
        // editar

        // excluir



    // =================================
    //            EVENTOS
    // =================================
        // listar

        // criar

        // editar

        // excluir