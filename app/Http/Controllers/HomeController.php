<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
class HomeController extends Controller
{
public function index(Request $request) // Añadimos Request para capturar ?page=
    {
        $token = session('token');
        $usuarioId = session('user_id');
        $url = "https://raestreadorfijo.vercel.app/api/mascotas/usuario/" . $usuarioId;

        try {
            $response = Http::timeout(15)
                ->withoutVerifying()
                ->withToken($token)
                ->get($url);

            if ($response->failed()) {
                return "Error en Vercel: " . $response->status();
            }

            $data = $response->json();
            if (is_null($data) || !isset($data["mascotas"])) {
                return "No se encontraron datos de mascotas.";
            }

            // Convertimos a Colección
            $mascotasRaw = collect($data["mascotas"]);

            // --- LÓGICA DE PAGINACIÓN ---
            $porPagina = 3; // Cambia este número para mostrar más o menos filas
            $paginaActual = $request->input('page', 1);
            
            // "Cortamos" la colección según la página
            $offset = ($paginaActual - 1) * $porPagina;
            $itemsPagina = $mascotasRaw->slice($offset, $porPagina)->all();

            // Creamos el objeto paginador manualmente
            $recientes = new LengthAwarePaginator(
                $itemsPagina,
                $mascotasRaw->count(),
                $porPagina,
                $paginaActual,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            // Cálculos para los widgets
            $geocercasActivas = $mascotasRaw->where('geoActive', true)->count();
            $alertasGeocerca = $mascotasRaw->where('alerta_geocerca', true)->count();
            $totalMascotas = $mascotasRaw->count();
            $bateriaBaja = $mascotasRaw->filter(fn($m) => ($m['bateria'] ?? 100) < 20)->count();

            return view('dashboard.index', compact(
                'totalMascotas', 
                'bateriaBaja', 
                'recientes', // Ahora 'recientes' es un objeto paginable
                'geocercasActivas', 
                'alertasGeocerca'
            ));

        } catch (\Exception $e) {
            dd("Error de conexión: " . $e->getMessage());
        }
    }

    public function verMapa()
{
    $usuarioId = session('user_id');
    $response = Http::withToken(session('token'))
        ->get("https://raestreadorfijo.vercel.app/api/mascotas/usuario/" . $usuarioId);

    $mascotas = $response->successful() ? $data = $response->json()['mascotas'] : [];

    return view('mapa', compact('mascotas'));
}
}

