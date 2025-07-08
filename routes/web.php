<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MonitoreoController;

// Rutas de autenticación
Route::get('/', function () {
     return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Rutas de proyectos usando resource (incluye index, create, store, show, edit, update, destroy)
    Route::resource('proyectos', ProyectosController::class)->except(['show']);
    
    // Ruta adicional para mostrar un proyecto (si la necesitas específicamente)
    Route::get('/proyectos/{proyecto}', [ProyectosController::class, 'show'])->name('proyectos.show');
    // Rutas para manejo de PDFs
    Route::get('/proyectos/{proyecto}/download', [ProyectosController::class, 'downloadPdf'])
         ->name('proyectos.download');
    
    Route::get('/proyectos/{proyecto}/generate-pdf', [ProyectosController::class, 'generatePdf'])
         ->name('proyectos.generate-pdf');

    // Rutas de monitoreo
    Route::get('/monitoreo', [MonitoreoController::class, 'monitoreo'])->name('monitoreo');
    Route::get('/monitoreo/{id}', [MonitoreoController::class, 'show'])->name('monitoreo.show');

     // Ruta de proyectos
    Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
    
    // Ruta de monitoreo
    Route::get('/monitoreo', [ConvocatoriaController::class, 'index'])->name('monitoreo.index');
});
