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

    Route::get('/convocatorias-por-categoria/{id}', [ProyectosController::class, 'porCategoria']);

     // Ruta de proyectos
    Route::get('/proyectos', [ProyectosController::class, 'index'])->name('proyectos.index');
    
    // Ruta de monitoreo
   Route::prefix('monitoreo')->group(function () {
    Route::get('/', [MonitoreoController::class, 'index'])->name('monitoreo.index');
    Route::get('/convocatorias', [MonitoreoController::class, 'convocatorias'])->name('monitoreo.convocatorias');
    Route::get('/convocatoria/{convocatoria}/proyectos', [MonitoreoController::class, 'proyectosPorConvocatoria'])->name('monitoreo.convocatoria.proyectos');
    Route::put('/{proyecto}/status', [MonitoreoController::class, 'updateStatus'])->name('monitoreo.updateStatus');
Route::get('/monitoreo/{proyecto}', [MonitoreoController::class, 'show2'])->name('monitoreo.show2');

});
});
