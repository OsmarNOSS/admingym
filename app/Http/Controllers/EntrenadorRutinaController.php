<?php

namespace App\Http\Controllers;

use App\Models\Entrenador;
use App\Models\Rutina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EntrenadorRutinaController extends Controller
{
    private function obtenerEntrenador(): Entrenador
    {
        return Entrenador::with(['user', 'sucursal'])
            ->where('user_id', auth()->id())
            ->firstOrFail();
    }

    public function index()
    {
        $entrenador = $this->obtenerEntrenador();

        $rutinas = Rutina::latest()->get();

        return view('entrenador.rutinas.index', compact('entrenador', 'rutinas'));
    }

    public function create()
    {
        $entrenador = $this->obtenerEntrenador();

        return view('entrenador.rutinas.create', compact('entrenador'));
    }

    public function store(Request $request)
    {
        $this->obtenerEntrenador();

        $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string'],
            'nivel' => ['required', Rule::in(['principiante', 'intermedio', 'avanzado'])],
            'foto_portada' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $datos = [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'nivel' => $request->nivel,
            'es_vip' => $request->has('es_vip') ? 1 : 0,
            'activa' => $request->has('activa') ? 1 : 0,
        ];

        if ($request->hasFile('foto_portada')) {
            $datos['foto_portada'] = $request->file('foto_portada')->store('rutinas', 'public');
        }

        Rutina::create($datos);

        return redirect()
            ->route('entrenador-panel.rutinas.index')
            ->with('mensaje', 'Rutina creada correctamente.');
    }

    public function edit($id)
    {
        $entrenador = $this->obtenerEntrenador();

        $rutina = Rutina::findOrFail($id);

        return view('entrenador.rutinas.edit', compact('entrenador', 'rutina'));
    }

    public function update(Request $request, $id)
    {
        $this->obtenerEntrenador();

        $rutina = Rutina::findOrFail($id);

        $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string'],
            'nivel' => ['required', Rule::in(['principiante', 'intermedio', 'avanzado'])],
            'foto_portada' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $datos = [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'nivel' => $request->nivel,
            'es_vip' => $request->has('es_vip') ? 1 : 0,
            'activa' => $request->has('activa') ? 1 : 0,
        ];

        if ($request->hasFile('foto_portada')) {
            if ($rutina->foto_portada) {
                Storage::disk('public')->delete($rutina->foto_portada);
            }

            $datos['foto_portada'] = $request->file('foto_portada')->store('rutinas', 'public');
        }

        $rutina->update($datos);

        return redirect()
            ->route('entrenador-panel.rutinas.index')
            ->with('mensaje', 'Rutina actualizada correctamente.');
    }

    public function destroy($id)
    {
        $this->obtenerEntrenador();

        $rutina = Rutina::findOrFail($id);

        $rutina->update([
            'activa' => false,
        ]);

        return redirect()
            ->route('entrenador-panel.rutinas.index')
            ->with('mensaje', 'Rutina desactivada correctamente.');
    }
}