<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // 👈 Importante para las peticiones API

class MascotaController extends Controller
{
    private $apiUrl = "https://raestreadorfijo.vercel.app/api/mascotas";

public function index()
{
    $usuarioId = session('user_id');
    $response = Http::get($this->apiUrl . "/usuario/" . $usuarioId);

    if ($response->successful()) {
        $data = $response->json();
        // Guardamos solo el array de mascotas, no toda la respuesta
        $mascotas = $data['mascotas'] ?? []; 
    } else {
        $mascotas = [];
    }

    return view("mascotas.index", compact('mascotas'));
}


public function store(Request $request)
{
    // 1. Ver si tenemos el ID del usuario en sesión
    if (!session()->has('user_id')) {
        dd("Error: No hay user_id en la sesión de Laravel. Revisa el login.");
    }

    try {
        $url = "https://raestreadorfijo.vercel.app/api/mascotas/registrar";
        
        $response = Http::post($url, [
            'nombre'  => $request->nombre,
            'especie' => $request->especie,
            'mac'     => strtoupper($request->dispositivo_id),
            'usuario' => session('user_id'),
        ]);

        // 2. Si llega aquí, vemos qué respondió el server o por qué falló
        if ($response->failed()) {
            dd([
                "Mensaje" => "El servidor respondió con error",
                "Status"  => $response->status(),
                "Cuerpo"  => $response->json(),
                "URL_Intentada" => $url
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Mascota registrada');

    } catch (\Exception $e) {
        // 3. Si llega aquí, es que ni siquiera pudo conectar (DNS, Firewall, SSL)
        dd([
            "Mensaje" => "La petición ni siquiera salió del servidor de Laravel",
            "Error"   => $e->getMessage()
        ]);
    }
}

public function destroy($id)
{
    $token = session('token');
    
    // La URL de tu API de Express para eliminar
    $url = "https://raestreadorfijo.vercel.app/api/mascotas/" . $id;

    try {
        $response = Http::withToken($token)
            ->withoutVerifying()
            ->delete($url); // 👈 Usamos el método DELETE

        if ($response->successful()) {
            return redirect()->route('dashboard')
                ->with('success', 'Mascota eliminada correctamente.');
        }

        return back()->with('error', 'No se pudo eliminar la mascota en el servidor externo.');

    } catch (\Exception $e) {
        return back()->with('error', 'Error de conexión: ' . $e->getMessage());
    }
}
public function historial(Request $request, $id = null)
{
    
    $token = session('token');
    $usuarioId = session('user_id');

    // TEST 1: ¿Tenemos sesión activa?
    if (!$token || !$usuarioId) {
        dd("Error: No hay token o ID de usuario en la sesión Laravel", session()->all());
    }

    // 1. Obtener lista de mascotas
    $resMascotas = Http::withToken($token)
        ->withoutVerifying()
        ->get("https://raestreadorfijo.vercel.app/api/mascotas/usuario/" . $usuarioId);
    
    // TEST 2: ¿Express responde la lista de mascotas?
    if ($resMascotas->failed()) {
        dd("Error al conectar con Express (Lista Mascotas):", $resMascotas->status(), $resMascotas->json());
    }

    $todasLasMascotas = $resMascotas->json()['mascotas'] ?? [];
   
    $desde = $request->input('desde', now()->subDay()->format('Y-m-d'));
    $hasta = $request->input('hasta', now()->format('Y-m-d'));
    $puntos = [];
    $mascotaActiva = null;

    // 2. Si hay ID, pedir historial
    if ($id) {
        $resHistorial = Http::withToken($token)
            ->withoutVerifying()
            ->get("https://raestreadorfijo.vercel.app/api/mascotas/{$id}/historial", [
                'desde' => $desde,
                'hasta' => $hasta
            ]);

        // TEST 3: ¿Express responde el historial?
        if ($resHistorial->failed()) {
            dd("Error al obtener historial de Express:", $resHistorial->status(), $resHistorial->json());
        }

        $puntos = $resHistorial->json();
        $mascotaActiva = collect($todasLasMascotas)->firstWhere('_id', $id);
    }

    // TEST 4: Ver qué estamos enviando a la vista
    // Si llegas aquí, las variables DEBEN existir
    // dd($todasLasMascotas, $puntos, $mascotaActiva);

    return view('mapa
    ', compact('todasLasMascotas', 'puntos', 'mascotaActiva'));
}

public function updateFoto(Request $request, $id)
{
    // 1. Validar que realmente sea una imagen
    $request->validate([
        'foto' => 'required|image|max:4096', // Máximo 2MB
    ]);

    if ($request->hasFile('foto')) {
        $foto = $request->file('foto');

        // 2. Enviar a la API de Express
        // Usamos attach para mandar el archivo como 'multipart/form-data'
        $response = Http::attach(
            'foto', 
            file_get_contents($foto->getRealPath()), 
            $foto->getClientOriginalName()
        )->post($this->apiUrl ."/". $id . "/foto");

        if ($response->successful()) {
            return back()->with('success', '¡Foto actualizada correctamente!');
        }
    }

    return back()->with('error', 'No se pudo subir la foto.');
}
}