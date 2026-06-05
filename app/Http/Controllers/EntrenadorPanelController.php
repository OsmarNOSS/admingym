<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ClienteEntrenador;
use App\Models\ClienteRutina;
use App\Models\Entrenador;
use App\Models\Rutina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EntrenadorPanelController extends Controller
{
    private function obtenerEntrenador(): Entrenador
    {
        return Entrenador::with(['user', 'sucursal'])
            ->where('user_id', auth()->id())
            ->firstOrFail();
    }

    public function misClientes(Request $request)
    {
    $entrenador = $this->obtenerEntrenador();

    $busqueda = $request->input('buscar');

    $clientes = $entrenador->clientes()
        ->with([
            'user',
            'sucursal',
            'membresias' => function ($query) {
                $query->where('activa', true)
                    ->latest();
            }
        ])
        ->wherePivot('activo', true)
        ->when($busqueda, function ($query) use ($busqueda) {
            $query->whereHas('user', function ($q) use ($busqueda) {
                $q->where('name', 'like', '%' . $busqueda . '%')
                  ->orWhere('email', 'like', '%' . $busqueda . '%');
            });
        })
        ->get();

        return view('entrenador.mis-clientes', compact('entrenador', 'clientes', 'busqueda'));
    }

    public function elegirClientes()
    {
        $entrenador = $this->obtenerEntrenador();

        $clientes = Cliente::with(['user', 'sucursal'])
            ->where('sucursal_id', $entrenador->sucursal_id)
            ->where('activo', true)
            ->orderBy('id')
            ->get();

        $clientesAsignadosIds = ClienteEntrenador::where('entrenador_id', $entrenador->id)
            ->where('activo', true)
            ->pluck('cliente_id')
            ->toArray();

        return view('entrenador.elegir-clientes', compact(
            'entrenador',
            'clientes',
            'clientesAsignadosIds'
        ));
    }

    public function guardarClientes(Request $request)
    {
        $entrenador = $this->obtenerEntrenador();

        $request->validate([
            'clientes' => ['nullable', 'array'],
            'clientes.*' => ['exists:clientes,id'],
        ]);

        $clientesSeleccionados = $request->clientes ?? [];

        DB::transaction(function () use ($clientesSeleccionados, $entrenador) {
            ClienteEntrenador::where('entrenador_id', $entrenador->id)
                ->whereNotIn('cliente_id', $clientesSeleccionados)
                ->update(['activo' => false]);

            foreach ($clientesSeleccionados as $clienteId) {
                $cliente = Cliente::where('id', $clienteId)
                    ->where('sucursal_id', $entrenador->sucursal_id)
                    ->where('activo', true)
                    ->first();

                if (!$cliente) {
                    continue;
                }

                ClienteEntrenador::where('cliente_id', $cliente->id)
                    ->where('entrenador_id', '!=', $entrenador->id)
                    ->update(['activo' => false]);

                ClienteEntrenador::updateOrCreate(
                    [
                        'cliente_id' => $cliente->id,
                        'entrenador_id' => $entrenador->id,
                    ],
                    [
                        'fecha_asignacion' => now()->toDateString(),
                        'activo' => true,
                    ]
                );
            }
        });

        return redirect()
            ->route('entrenador-panel.mis-clientes')
            ->with('mensaje', 'Clientes actualizados correctamente.');
    }

    public function asignarRutina($clienteId)
    {
        $entrenador = $this->obtenerEntrenador();

        $cliente = Cliente::with([
                'user',
                'sucursal',
                'membresias' => function ($query) {
                    $query->where('activa', true)
                        ->latest();
                }
            ])
            ->where('id', $clienteId)
            ->firstOrFail();

        ClienteEntrenador::where('cliente_id', $cliente->id)
            ->where('entrenador_id', $entrenador->id)
            ->where('activo', true)
            ->firstOrFail();

        $rutinas = Rutina::where('activa', true)
            ->orderBy('nombre')
            ->get();

        $membresiaActiva = $cliente->membresias->first();

        return view('entrenador.asignar-rutina', compact(
            'entrenador',
            'cliente',
            'rutinas',
            'membresiaActiva'
        ));
    }

    public function guardarRutina(Request $request, $clienteId)
    {
        $entrenador = $this->obtenerEntrenador();

        $cliente = Cliente::with([
                'membresias' => function ($query) {
                    $query->where('activa', true)
                        ->latest();
                }
            ])
            ->where('id', $clienteId)
            ->firstOrFail();

        ClienteEntrenador::where('cliente_id', $cliente->id)
            ->where('entrenador_id', $entrenador->id)
            ->where('activo', true)
            ->firstOrFail();

        $request->validate([
            'rutina_id' => ['required', 'exists:rutinas,id'],
            'fecha_asignacion' => ['required', 'date'],
        ]);

        $rutina = Rutina::where('activa', true)
            ->findOrFail($request->rutina_id);

        $membresiaActiva = $cliente->membresias->first();

if (!$membresiaActiva) {
    return redirect()
        ->back()
        ->withErrors([
            'rutina_id' => 'No puedes asignar una rutina porque el cliente no tiene una membresía activa.',
        ])
        ->withInput();
}

if (!$membresiaActiva->estaVigente()) {
    return redirect()
        ->back()
        ->withErrors([
            'rutina_id' => 'No puedes asignar una rutina porque la membresía del cliente no está vigente.',
        ])
        ->withInput();
}

$tieneVip = $membresiaActiva->tipo === 'vip';

if ($rutina->es_vip && !$tieneVip) {
    return redirect()
        ->back()
        ->withErrors([
            'rutina_id' => 'No puedes asignar una rutina VIP a un cliente sin membresía VIP vigente.',
        ])
        ->withInput();
}

        ClienteRutina::updateOrCreate(
            [
                'cliente_id' => $cliente->id,
                'rutina_id' => $rutina->id,
            ],
            [
                'entrenador_id' => $entrenador->id,
                'fecha_asignacion' => $request->fecha_asignacion,
                'activa' => true,
            ]
        );

        return redirect()
            ->route('entrenador-panel.mis-clientes')
            ->with('mensaje', 'Rutina asignada correctamente.');
    }

    public function perfil()
{
    $entrenador = $this->obtenerEntrenador();

    return view('entrenador.perfil', compact('entrenador'));
}

public function editPerfil()
{
    $entrenador = $this->obtenerEntrenador();

    return view('entrenador.edit-perfil', compact('entrenador'));
}

public function updatePerfil(Request $request)
{
    $entrenador = $this->obtenerEntrenador();

    $request->validate([
        'telefono' => ['nullable', 'string', 'max:20'],
        'especialidad' => ['nullable', 'string', 'max:100'],
        'foto_perfil' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
    ]);

    $datos = [
        'telefono' => $request->telefono,
        'especialidad' => $request->especialidad,
    ];

    if ($request->hasFile('foto_perfil')) {
        if ($entrenador->foto_perfil) {
            Storage::disk('public')->delete($entrenador->foto_perfil);
        }

        $datos['foto_perfil'] = $request->file('foto_perfil')->store('entrenadores', 'public');
    }

    $entrenador->update($datos);

    return redirect()
        ->route('entrenador-panel.perfil')
        ->with('mensaje', 'Perfil actualizado correctamente.');
    }
    public function rutinasCliente($clienteId)
{
    $entrenador = $this->obtenerEntrenador();

    $cliente = Cliente::with(['user', 'sucursal'])
        ->where('id', $clienteId)
        ->firstOrFail();

    ClienteEntrenador::where('cliente_id', $cliente->id)
        ->where('entrenador_id', $entrenador->id)
        ->where('activo', true)
        ->firstOrFail();

    $rutinasAsignadas = ClienteRutina::with(['rutina', 'entrenador.user'])
        ->where('cliente_id', $cliente->id)
        ->where('entrenador_id', $entrenador->id)
        ->where('activa', true)
        ->latest('fecha_asignacion')
        ->get();

    return view('entrenador.rutinas-cliente', compact(
        'entrenador',
        'cliente',
        'rutinasAsignadas'
    ));
}

public function quitarRutina($clienteId, $asignacionId)
{
    $entrenador = $this->obtenerEntrenador();

    $cliente = Cliente::where('id', $clienteId)->firstOrFail();

    ClienteEntrenador::where('cliente_id', $cliente->id)
        ->where('entrenador_id', $entrenador->id)
        ->where('activo', true)
        ->firstOrFail();

    $asignacion = ClienteRutina::where('id', $asignacionId)
        ->where('cliente_id', $cliente->id)
        ->where('entrenador_id', $entrenador->id)
        ->where('activa', true)
        ->firstOrFail();

    $asignacion->update([
        'activa' => false,
    ]);

        return redirect()
            ->route('entrenador-panel.rutinas-cliente', $cliente->id)
            ->with('mensaje', 'Rutina quitada correctamente.');
    }

}