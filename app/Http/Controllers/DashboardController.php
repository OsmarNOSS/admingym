<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Membresia;
use App\Models\Asistencia;
use App\Models\Entrenador;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('cliente')) {
            return redirect()->route('cliente-panel.perfil');
        }

        if ($user->hasRole('entrenador')) {
            return redirect()->route('entrenador-panel.perfil');
        }

        if ($user->hasRole('recepcionista')) {
            return redirect()->route('recepcion.clientes.index');
        }

        $totalClientes = Cliente::count();

        $totalMembresias = Membresia::count();

        $membresiasActivas = Membresia::where('activa', true)->count();

        $membresiasProximasVencer = Membresia::with(['cliente.user', 'sucursal'])
            ->where('activa', true)
            ->whereBetween('fecha_fin', [
                Carbon::today(),
                Carbon::today()->addDays(7),
            ])
            ->orderBy('fecha_fin')
            ->get();

        $clientesConMasAsistencias = Cliente::with('user')
            ->withCount('asistencias')
            ->orderByDesc('asistencias_count')
            ->take(5)
            ->get();

        $entrenadoresConMasAlumnos = Entrenador::with(['user', 'sucursal'])
        ->withCount([
            'clientes as alumnos_count' => function ($query) {
            $query->where('cliente_entrenador.activo', true);
            }
        ])
        ->orderByDesc('alumnos_count')
        ->take(5)
        ->get();

        return view('dashboard', compact(
            'totalClientes',
            'totalMembresias',
            'membresiasActivas',
            'membresiasProximasVencer',
            'clientesConMasAsistencias',
            'entrenadoresConMasAlumnos'
        ));
    }
}