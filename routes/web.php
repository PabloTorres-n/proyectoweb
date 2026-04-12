<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

// --- RUTAS PÚBLICAS (No necesitan sesión) ---
Route::get('/', function () {
    return view('welcome');
});

// Autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/registro', [AuthController::class, 'showRegistro'])->name('registro.index');
Route::post('/registro', [AuthController::class, 'register'])->name('registro.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- RUTAS PROTEGIDAS (Solo con sesión/token activo) ---
Route::middleware(['auth.token'])->group(function () {

    // Dashboard Principal
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Gestión de Mascotas (Resource crea index, create, store, show, edit, update, destroy)
    Route::resource('mascotas', MascotaController::class);
    
    // Rutas adicionales de Mascotas (Deben ir fuera o después del resource si son específicas)
    Route::post('/mascotas/{id}/foto', [MascotaController::class, 'updateFoto'])->name('mascotas.updateFoto');
    Route::get('/historial/{id?}', [MascotaController::class, 'historial'])->name('mapa.index');

    // Usuario
    Route::get('/perfil', function () {
        return view('cliente.perfil');
    })->name('perfil');

    Route::get('/configuracion', function () {
        return view('configuracion');
    })->name('configuracion');

});