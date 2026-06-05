<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $datos['sucursales'] = Sucursal::all();
        return view('sucursal.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('sucursal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datosSucursal = request()->except('_token');

        $datosSucursal['activa'] = $request->has('activa') ? 1 : 0;

        if ($request->hasFile('foto_portada')) {
            $datosSucursal['foto_portada'] = $request->file('foto_portada')->store('sucursales', 'public');
        }

        Sucursal::insert($datosSucursal);
        return redirect('sucursal')->with('mensaje', 'Sucursal agregada con exito.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $sucursal = Sucursal::findOrFail($id);
        return view('sucursal.show',compact('sucursal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $sucursal = Sucursal::findOrFail($id);
        return view('sucursal.edit', compact('sucursal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $datosSucursal = request()->except(['_token', '_method']);
        $datosSucursal['activa'] = $request->has('activa') ? 1 : 0;
        if ($request->hasFile('foto_portada')) {
            $sucursal = Sucursal::findOrFail($id);
            Storage::delete('public/' . $sucursal->foto_portada);
            $datosSucursal['foto_portada'] = $request->file('foto_portada')->store('sucursales', 'public');
        }
        Sucursal::where('id', '=', $id)->update($datosSucursal);

        $sucursal = Sucursal::findOrFail($id);
        return view('sucursal.edit', compact('sucursal'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $sucursal = Sucursal::findOrFail($id);

        // Borrar la imagen si existe
        if ($sucursal->foto_portada) {
            Storage::disk('public')->delete($sucursal->foto_portada);
        }

        $sucursal->delete();

        return redirect('sucursal')->with('mensaje', 'Sucursal eliminada con exito.');
    }
}
