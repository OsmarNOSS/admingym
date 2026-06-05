<?php

namespace App\Http\Controllers;

use App\Models\Entrenador;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EntrenadorController extends Controller
{
    public function index()
    {
        $entrenadores = Entrenador::with(['user', 'sucursal'])->get();

        return view('entrenador.index', compact('entrenadores'));
    }

    public function create()
    {
        $sucursales = Sucursal::where('activa', true)->get();

        return view('entrenador.create', compact('sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'sucursal_id' => ['required', 'exists:sucursales,id'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'especialidad' => ['nullable', 'string', 'max:100'],
            'foto_perfil' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        DB::transaction(function () use ($request) {
            $fotoPath = null;

            if ($request->hasFile('foto_perfil')) {
                $fotoPath = $request->file('foto_perfil')->store('entrenadores', 'public');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rol' => 'entrenador',
                'sucursal_id' => $request->sucursal_id,
            ]);

            $user->syncRoles(['entrenador']);

            Entrenador::create([
        'user_id' => $user->id,
        'sucursal_id' => $request->sucursal_id,
        'telefono' => $request->telefono,
        'especialidad' => $request->especialidad,
        'activo' => $request->has('activo') ? 1 : 0,
        'foto_perfil' => $fotoPath,
        ]);
        });

        return redirect()
            ->route('entrenador.index')
            ->with('mensaje', 'Entrenador agregado con éxito.');
    }

    public function show($id)
    {
        $entrenador = Entrenador::with(['user', 'sucursal'])->findOrFail($id);

        return view('entrenador.show', compact('entrenador'));
    }

    public function edit($id)
    {
        $entrenador = Entrenador::with(['user', 'sucursal'])->findOrFail($id);
        $sucursales = Sucursal::where('activa', true)->get();

        return view('entrenador.edit', compact('entrenador', 'sucursales'));
    }

    public function update(Request $request, $id)
    {
        $entrenador = Entrenador::with('user')->findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email,' . $entrenador->user_id],
            'password' => ['nullable', 'string', 'min:8'],
            'sucursal_id' => ['required', 'exists:sucursales,id'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'especialidad' => ['nullable', 'string', 'max:100'],
            'foto_perfil' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        DB::transaction(function () use ($request, $entrenador) {
            $entrenador->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'rol' => 'entrenador',
                'sucursal_id' => $request->sucursal_id,
            ]);

            $entrenador->user->syncRoles(['entrenador']);

            if ($request->filled('password')) {
                $entrenador->user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            $datosEntrenador = [
                'sucursal_id' => $request->sucursal_id,
                'telefono' => $request->telefono,
                'especialidad' => $request->especialidad,
                'activo' => $request->has('activo') ? 1 : 0,
            ];

            if ($request->hasFile('foto_perfil')) {
                if ($entrenador->foto_perfil) {
                    Storage::disk('public')->delete($entrenador->foto_perfil);
                }

                $datosEntrenador['foto_perfil'] = $request->file('foto_perfil')->store('entrenadores', 'public');
            }

            $entrenador->update($datosEntrenador);
        });

        return redirect()
            ->route('entrenador.index')
            ->with('mensaje', 'Entrenador actualizado correctamente.');
    }

    public function destroy($id)
    {
        $entrenador = Entrenador::with('user')->findOrFail($id);

        if ($entrenador->foto_perfil) {
            Storage::disk('public')->delete($entrenador->foto_perfil);
        }

        if ($entrenador->user) {
            $entrenador->user->delete();
        } else {
            $entrenador->delete();
        }

        return redirect()
            ->route('entrenador.index')
            ->with('mensaje', 'Entrenador eliminado con éxito.');
    }
}