<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// 1. Ruta para ver el formulario de registro
Route::get('/registro', [AuthController::class, 'showRegistro'])->name('registro.index');

// 2. Ruta para procesar el envío de datos a Express
Route::post('/registro', [AuthController::class, 'register'])->name('registro.post');

// 3. Ruta para cerrar sesión (opcional pero necesaria)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Vistas de Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// 2. LA RUTA MAESTRA: Crea 7 rutas automáticas (index, edit, update, etc.)
Route::resource('mascotas', MascotaController::class);


Route::get('/perfil', function () {
    return view('cliente.perfil');
})->name('perfil');

Route::get('/configuracion', function () {
    return view('configuracion');
})->name('configuracion');


//
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::get('/historial/{id?}', [MascotaController::class, 'historial'])->name('mapa.index');