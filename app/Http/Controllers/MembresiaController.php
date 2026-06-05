<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Membresia;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MembresiaController extends Controller
{
    public function index()
    {
        $membresias = Membresia::with(['cliente.user', 'sucursal'])
            ->latest()
            ->get();

        return view('membresia.index', compact('membresias'));
    }

    public function create()
    {
        $clientes = Cliente::with('user')
            ->where('activo', true)
            ->get();

        $sucursales = Sucursal::where('activa', true)->get();

        return view('membresia.create', compact('clientes', 'sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => ['required', 'exists:clientes,id'],
            'sucursal_id' => ['required', 'exists:sucursales,id'],
            'tipo' => ['required', Rule::in(['basic', 'premium', 'vip'])],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date', 'after_or_equal:fecha_inicio'],
        ]);

        if ($request->has('activa')) {
            Membresia::where('cliente_id', $request->cliente_id)
                ->where('activa', true)
                ->update(['activa' => false]);
        }

        Membresia::create([
            'cliente_id' => $request->cliente_id,
            'sucursal_id' => $request->sucursal_id,
            'tipo' => $request->tipo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'activa' => $request->has('activa') ? 1 : 0,
        ]);

        return redirect()
            ->route('membresia.index')
            ->with('mensaje', 'Membresía registrada correctamente.');
    }

    public function show($id)
    {
        $membresia = Membresia::with(['cliente.user', 'sucursal'])
            ->findOrFail($id);

        return view('membresia.show', compact('membresia'));
    }

    public function edit($id)
    {
        $membresia = Membresia::findOrFail($id);

        $clientes = Cliente::with('user')
            ->where('activo', true)
            ->get();

        $sucursales = Sucursal::where('activa', true)->get();

        return view('membresia.edit', compact('membresia', 'clientes', 'sucursales'));
    }

    public function update(Request $request, $id)
    {
        $membresia = Membresia::findOrFail($id);

        $request->validate([
            'cliente_id' => ['required', 'exists:clientes,id'],
            'sucursal_id' => ['required', 'exists:sucursales,id'],
            'tipo' => ['required', Rule::in(['basic', 'premium', 'vip'])],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date', 'after_or_equal:fecha_inicio'],
        ]);

        if ($request->has('activa')) {
            Membresia::where('cliente_id', $request->cliente_id)
                ->where('id', '!=', $membresia->id)
                ->where('activa', true)
                ->update(['activa' => false]);
        }

        $membresia->update([
            'cliente_id' => $request->cliente_id,
            'sucursal_id' => $request->sucursal_id,
            'tipo' => $request->tipo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'activa' => $request->has('activa') ? 1 : 0,
        ]);

        return redirect()
            ->route('membresia.index')
            ->with('mensaje', 'Membresía actualizada correctamente.');
    }

    public function destroy($id)
    {
        $membresia = Membresia::findOrFail($id);
        $membresia->delete();

        return redirect()
            ->route('membresia.index')
            ->with('mensaje', 'Membresía eliminada correctamente.');
    }
}