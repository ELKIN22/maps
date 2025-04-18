<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ubicacion;

class UbicacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

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
    public function show(string $id)
    {
        return Ubicacion::with('tipo','imagenes')->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function buscarUbicaciones(string $busqueda)
    {
     
        $busqueda = trim($busqueda);
    
        if ($busqueda === '') {
            return response()->json([]);
        }
    
        $ubicaciones = Ubicacion::with('tipo','imagenes')->when($busqueda === '@', function ($query) {
                $query->where('destacada', true);
            }, function ($query) use ($busqueda) {
                $query->where('nombre', 'LIKE', "%{$busqueda}%");
            })
            ->limit(25)
            ->get();
    
        return response()->json($ubicaciones);
    }
    
  
}
