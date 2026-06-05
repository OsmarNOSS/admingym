<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ClienteEntrenador;
use App\Models\ClienteRutina;

class ClientePanelController extends Controller
{
    public function perfil()
    {
        $cliente = Cliente::with(['user', 'sucursal'])
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('cliente.perfil', compact('cliente'));
    }

    public function editPerfil()
    {
        $cliente = Cliente::with(['user', 'sucursal'])
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('cliente.edit-perfil', compact('cliente'));
    }

    public function updatePerfil(Request $request)
    {
        $cliente = Cliente::where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'peso' => ['nullable', 'numeric', 'min:1', 'max:300'],
            'altura' => ['nullable', 'numeric', 'min:0.50', 'max:2.50'],
            'foto_perfil' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $datos = [
            'peso' => $request->peso,
            'altura' => $request->altura,
        ];

        if ($request->hasFile('foto_perfil')) {
            if ($cliente->foto_perfil) {
                Storage::disk('public')->delete($cliente->foto_perfil);
            }

            $datos['foto_perfil'] = $request->file('foto_perfil')->store('clientes', 'public');
        }

        $cliente->update($datos);

        return redirect()
            ->route('cliente-panel.perfil')
            ->with('mensaje', 'Perfil actualizado correctamente.');
    }

    public function membresia()
    {
        $cliente = Cliente::with([
                'user',
                'sucursal',
                'membresias' => function ($query) {
                    $query->where('activa', true)
                          ->latest();
                }
            ])
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $membresiaActiva = $cliente->membresias->first();

        return view('cliente.membresia', compact('cliente', 'membresiaActiva'));
    }

    public function entrenador()
    {
        $cliente = Cliente::with(['user', 'sucursal'])
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $asignacion = ClienteEntrenador::with([
            'entrenador.user',
            'entrenador.sucursal'
        ])
        ->where('cliente_id', $cliente->id)
        ->where('activo', true)
        ->latest('fecha_asignacion')
        ->first();

        return view('cliente.entrenador', compact('cliente', 'asignacion'));
    }


    public function rutinas()
{
    $cliente = Cliente::with([
            'user',
            'sucursal',
            'membresias' => function ($query) {
                $query->where('activa', true)
                    ->latest();
            }
        ])
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $membresiaActiva = $cliente->membresias->first();

    $tieneVip = $membresiaActiva &&
        $membresiaActiva->estaVigente() &&
        $membresiaActiva->tipo === 'vip';

    $rutinasAsignadas = ClienteRutina::with(['rutina', 'entrenador.user'])
        ->where('cliente_id', $cliente->id)
        ->where('activa', true)
        ->latest('fecha_asignacion')
        ->get();

    return view('cliente.rutinas', compact(
        'cliente',
        'membresiaActiva',
        'tieneVip',
        'rutinasAsignadas'
    ));
}
}