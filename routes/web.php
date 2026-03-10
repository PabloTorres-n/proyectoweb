<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/probar-mongo', function () {
    try {
        // Intenta hacer un ping a Atlas
        DB::connection('mongodb')->command(['ping' => 1]);
        return "✅ ¡Conexión exitosa con MongoDB Atlas!";
    } catch (\Exception $e) {
        return "❌ Error de conexión: " . $e->getMessage();
    }
});


// 2. LA RUTA MAESTRA: Crea 7 rutas automáticas (index, edit, update, etc.)
Route::resource('mascotas', MascotaController::class);


Route::get('/perfil', function () {
    return view('cliente.perfil');
})->name('perfil');

Route::get('/configuracion', function () {
    return view('configuracion');
})->name('configuracion');



Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');