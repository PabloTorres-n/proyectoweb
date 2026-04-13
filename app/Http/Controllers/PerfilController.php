<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PerfilController extends Controller
{
    private $apiUrl = "https://raestreadorfijo.vercel.app/api/clientes";

public function index()
{
    $userId = session('user_id');
    $token = session('token');

    $response = Http::withToken($token)->get("{$this->apiUrl}/collares/{$userId}");
    $userRes = Http::withToken($token)->get("{$this->apiUrl}/{$userId}");

    $collaresRaw = $response->json()['collares'] ?? [];

    $collares = collect($collaresRaw)->map(function($c) {
        return [
            'collarId' => $c['collarId'] ?? '---',
            'apodo'    => $c['apodo'] ?? 'Sin apodo',
            'estado'   => $c['estado'] ?? 'inactivo',
            'bateria'  => $c['bateria'] ?? 0,
            // Accedemos directo al objeto populado que vimos en tu dd()
            'foto'     => $c['mascotaActual']['foto_url'] ?? null,
            'perro'    => $c['mascotaActual']['nombre'] ?? 'Sin asignar'
        ];
    });
    //dd($collares,$userRes->json());
    return view('cliente.perfil', [
        'user' => $userRes->json(),
        'collares' => $collares
    ]);
}

  public function update(Request $request)
{
    $token = session('token');
    $userId = session('user_id');

    // 1. Validamos los datos antes de enviarlos a Express
    $request->validate([
        'nombre'    => 'required|string|max:255',
        'telefono'  => 'nullable|string|max:20',
        'direccion' => 'nullable|string', // Lo recibimos como texto desde el textarea
    ]);

    // 2. Enviamos la actualización a Express
    // Nota: Usamos la URL que definiste en tu backend para actualizar perfil
    $response = Http::withToken($token)->put("{$this->apiUrl}/actualizar-perfil/{$userId}", [
        'nombre'    => $request->nombre,
        'telefono'  => $request->telefono,
        'direccion' => $request->direccion, // Express se encargará de hacer el .split(',')
    ]);

    // 3. Verificamos la respuesta del servidor Node.js
    if ($response->successful()) {
        // Actualizamos el nombre en la sesión de Laravel para que el header cambie de inmediato
        session(['user_name' => $request->nombre]);
        
        // Si en tu controlador de perfil guardas el objeto $user completo, 
        // podrías necesitar refrescar esos datos o simplemente volver con éxito
        return back()->with('success', '¡Perfil actualizado correctamente en el ecosistema!');
    }

    // 4. Si Express responde con error (400, 500, etc.)
    return back()->withErrors(['error' => 'Hubo un problema al conectar con el servidor de Athayala.']);
}

    public function updateFoto(Request $request, $id)
{
    // 1. Validar (Subimos a 4MB como en tu ejemplo de mascotas)
    $request->validate([
        'foto' => 'required|image|max:4096', 
    ]);

    if ($request->hasFile('foto')) {
        $foto = $request->file('foto');
        $token = session('token');

        // 2. Enviar a la API de Express usando attach (Multipart)
        $response = Http::withToken($token)
            ->attach(
                'foto', 
                file_get_contents($foto->getRealPath()), 
                $foto->getClientOriginalName()
            )
            ->post($this->apiUrl . "/" . $id . "/foto");

        if ($response->successful()) {
            // Opcional: Actualizar la foto en la sesión si la API te devuelve la nueva URL
            $data = $response->json();
            if(isset($data['foto_url'])) {
                session(['user_foto' => $data['foto_url']]);
            }

            return back()->with('success', '¡Foto de perfil actualizada!');
        }
    }

    return back()->with('error', 'No se pudo subir la foto al servidor.');
}
}