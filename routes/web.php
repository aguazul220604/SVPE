<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\Auth\LoginController; 


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::post('/login', [LoginController::class, 'login']);


Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

//  autenticación
Route::middleware(['auth'])->group(function () {
        
        // Ruta principal 
        Route::get('/proyectos', [ProyectosController::class, 'index'])->name('proyectos.index');

        // formulario de creación
        Route::get('/proyectos/create', [ProyectosController::class, 'create'])->name('proyectos.create');

        // nuevo proyecto
        Route::post('/proyectos', [ProyectosController::class, 'store'])->name('proyectos.store');

        // Ruta para mostrar un proyecto específico
        Route::get('/proyectos/{proyecto}', [ProyectosController::class, 'show'])->name('proyectos.show');

        
        Route::resource('proyectos', 'App\Http\Controllers\ProyectosController');

        //  formulario de edición
        Route::get('/proyectos/{proyecto}/edit', [ProyectosController::class, 'edit'])->name('proyectos.edit');
        });
