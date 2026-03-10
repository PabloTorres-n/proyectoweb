<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $userFixedId = '69ac8291ce4023738b784bf4';

    public function index()
    {
      $idFijo = (string) $this->userFixedId;
    
    $mascotas = Mascota::where('usuario', $idFijo)->get();

    // Si sigue saliendo vacío, usa la Opción B (Forzar coincidencia):
    if ($mascotas->isEmpty()) {
        // Esto traerá las que NO tienen el ID de usuario bien puesto 
        // solo para que veas qué ID tienen guardado realmente.
        $mascotas = Mascota::all(); 
    }

    return view("mascotas.index", compact('mascotas'));
    }

    // Mostrar el formulario de registro
    public function create()
    {
        return view("mascotas.create");
    }
    /**
     * Show the form for creating a new resource.
     */
   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Mascota $mascota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mascota $mascota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mascota $mascota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mascota $mascota)
    {
        //
    }
}
