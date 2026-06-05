<?php

namespace App\Http\Controllers\Recepcion;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Membresia;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

//este controlador es para que los recepcionistas puedan acceder a las membresias de SU SUCURSAL
class MembresiaRecepcionController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $sucursalId = $user->sucursal_id;

        if (!$sucursalId && $user->hasRole('super_admin')) {
            $sucursalId = Sucursal::where('activa', true)->orderBy('id')->value('id');
        }

        $sucursal = Sucursal::find($sucursalId);

        $membresias = Membresia::with(['cliente.user', 'sucursal'])
            ->where('sucursal_id', $sucursalId)
            ->latest()
            ->get();

        return view('recepcion.membresias.index', compact('membresias', 'sucursal'));
    }

    public function create()
    {
        $user = auth()->user();

        $sucursalId = $user->sucursal_id;

        if (!$sucursalId && $user->hasRole('super_admin')) {
            $sucursalId = Sucursal::where('activa', true)->orderBy('id')->value('id');
        }

        $sucursal = Sucursal::findOrFail($sucursalId);

        $clientes = Cliente::with('user')
            ->where('sucursal_id', $sucursalId)
            ->where('activo', true)
            ->get();

        return view('recepcion.membresias.create', compact('clientes', 'sucursal'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $sucursalId = $user->sucursal_id;

        if (!$sucursalId && $user->hasRole('super_admin')) {
            $sucursalId = Sucursal::where('activa', true)->orderBy('id')->value('id');
        }

        $request->validate([
            'cliente_id' => ['required', 'exists:clientes,id'],
            'tipo' => ['required', Rule::in(['basic', 'premium', 'vip'])],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date', 'after_or_equal:fecha_inicio'],
        ]);

        $cliente = Cliente::where('id', $request->cliente_id)
            ->where('sucursal_id', $sucursalId)
            ->firstOrFail();

        Membresia::where('cliente_id', $cliente->id)
            ->where('activa', true)
            ->update(['activa' => false]);

        Membresia::create([
            'cliente_id' => $cliente->id,
            'sucursal_id' => $sucursalId,
            'tipo' => $request->tipo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'activa' => true,
        ]);

        return redirect()
            ->route('recepcion.membresias.index')
            ->with('mensaje', 'Membresía registrada correctamente.');
    }
}