<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\Cliente;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $sucursalId = $user->sucursal_id;

        if (!$sucursalId && $user->hasRole('super_admin')) {
            $sucursalId = Sucursal::where('activa', true)->orderBy('id')->value('id');
        }

        $sucursal = Sucursal::find($sucursalId);

        $asistencias = Asistencia::with(['cliente.user', 'sucursal', 'membresia', 'registradoPor'])
            ->where('sucursal_id', $sucursalId)
            ->whereDate('fecha_entrada', now()->toDateString())
            ->latest('fecha_entrada')
            ->get();

        return view('asistencias.index', compact('asistencias', 'sucursal'));
    }

    public function create()
    {
        $user = auth()->user();
        $sucursalId = $user->sucursal_id;

        if (!$sucursalId && $user->hasRole('super_admin')) {
            $sucursalId = Sucursal::where('activa', true)->orderBy('id')->value('id');
        }

        $sucursal = Sucursal::findOrFail($sucursalId);

        $clientes = Cliente::with(['user', 'membresias'])
            ->where('sucursal_id', $sucursalId)
            ->where('activo', true)
            ->get();

        return view('asistencias.create', compact('clientes', 'sucursal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => ['required', 'exists:clientes,id'],
        ]);

        $user = auth()->user();
        $sucursalId = $user->sucursal_id;

        if (!$sucursalId && $user->hasRole('super_admin')) {
            $sucursalId = Sucursal::where('activa', true)->orderBy('id')->value('id');
        }

        $cliente = Cliente::with(['user', 'membresias'])->findOrFail($request->cliente_id);

        $membresia = $cliente->membresias()
            ->where('activa', true)
            ->latest()
            ->first();

        $accesoPermitido = true;
        $motivoDenegacion = null;

        if (!$cliente->activo) {
            $accesoPermitido = false;
            $motivoDenegacion = 'Cliente inactivo.';
        } elseif (!$membresia) {
            $accesoPermitido = false;
            $motivoDenegacion = 'Cliente sin membresía activa.';
        } elseif (!$membresia->estaVigente()) {
            $accesoPermitido = false;
            $motivoDenegacion = 'Membresía vencida o fuera de vigencia.';
        } elseif ($membresia->tipo === 'basic' && (int) $membresia->sucursal_id !== (int) $sucursalId) {
            $accesoPermitido = false;
            $motivoDenegacion = 'La membresía Basic solo permite acceso a la sucursal donde fue contratada.';
        }

        $asistencia = Asistencia::create([
            'cliente_id' => $cliente->id,
            'sucursal_id' => $sucursalId,
            'registrado_por' => $user->id,
            'membresia_id' => $membresia?->id,
            'fecha_entrada' => now(),
            'acceso_permitido' => $accesoPermitido,
            'motivo_denegacion' => $motivoDenegacion,
        ]);

        if (!$accesoPermitido) {
            return redirect()
                ->route('asistencias.denegado', $asistencia->id);
        }

        return redirect()
            ->route('asistencias.index')
            ->with('mensaje', 'Acceso permitido. Asistencia registrada correctamente.');
    }

    public function denegado($id)
    {
        $asistencia = Asistencia::with(['cliente.user', 'sucursal', 'membresia'])
            ->findOrFail($id);

        return view('asistencias.denegado', compact('asistencia'));
    }
}