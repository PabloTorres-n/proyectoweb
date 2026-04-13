<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // 👈 Cliente HTTP de Laravel

class AuthController extends Controller
{
    // URL de tu backend en Vercel
    private $apiUrl = "https://raestreadorfijo.vercel.app/api/auth";

    /**
     * Muestra el formulario de registro
     */
    public function showRegistro()
    {
        return view('auth.registro');
    }

    /**
     * Procesa el registro enviando los datos a Express
     */
    public function register(Request $request)
    {
        // 1. Validar los datos que vienen de la vista Blade
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        // 2. Enviar la petición POST a tu Backend de Express
        $response = Http::post($this->apiUrl . "/registrar", [
            'nombre'   => $request->name,
            'correo'    => $request->email,
            'contrasena' => $request->password,
        ]);

        // 3. Revisar si Express aceptó el registro
        if ($response->successful()) {
            $data = $response->json();

            // 4. GUARDAR EN SESSION DE PHP (Igual que el LocalStorage pero en el servidor)
            session([
                 // El ID que genera MongoDB
                'token'   => $data['token'],         // El JWT que genera Express
                
            ]);

            // Redirigir al listado de mascotas
            return redirect()->route('login')->with('success', '¡Cuenta creada con éxito!');
        }

        // Si hubo un error (ej: el correo ya existe)
        return back()->withErrors(['error' => 'No se pudo crear la cuenta. Intente de nuevo.']);
    }

    /**
 * Muestra la vista de login
 */
public function showLogin()
{
    return view('auth.login');
}

/**
 * Procesa la autenticación
 */
public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    // Petición a Express
    $response = Http::post($this->apiUrl . "/login", [
        'correo'     => $request->email,
        'contrasena' => $request->password,
    ]);

    if ($response->successful()) {
        $data = $response->json();

        // Guardamos los datos clave en la sesión de PHP
        session([
            'token'   => $data['token'],
            'user_id' => $data['usuario']['id'] ?? null,
            'user_name' => $data['usuario']['nombre'] ?? 'Usuario',
        ]);

        return redirect()->route('dashboard');
    }

    // Si falla el login en Express
    return back()->withErrors(['error' => 'Correo o contraseña incorrectos.']);
}

    /**
     * Cerrar Sesión
     */
    public function logout()
    {
        session()->flush(); // Borra todo lo guardado en PHP
        return redirect()->route('registro.index');
    }

  public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6',
        'confirm_password' => 'required|same:new_password',
    ]);

    // Quitamos el dd($url) para que la ejecución siga
    $idUsuario = session('user_id');
    $token = session('token');

    try {
        // timeout(30) ayuda si Vercel tiene un 'cold start'
        $response = Http::timeout(30)
            ->withToken($token)
            ->put("{$this->apiUrl}/clientes/cambiar-password/{$idUsuario}", [
                'current_password' => $request->current_password,
                'new_password' => $request->new_password,
                'confirm_password' => $request->confirm_password,
            ]);

        if ($response->successful()) {
            return back()->with('success', '¡Contraseña actualizada con éxito!');
        }

        $errorMsg = $response->json()['msg'] ?? 'Error en el servidor de seguridad.';
        return back()->withErrors(['password_error' => $errorMsg]);

    } catch (\Exception $e) {
        // Esto captura si Vercel está caído o la URL es errónea
        return back()->withErrors(['password_error' => 'No se pudo conectar con el servidor: ' . $e->getMessage()]);
    }
}
}