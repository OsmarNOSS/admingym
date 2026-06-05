<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Entrenador;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::with(['roles', 'sucursal'])->get();

        return view('usuario.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Role::all();
        $sucursales = Sucursal::where('activa', true)->get();

        return view('usuario.create', compact('roles', 'sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'rol' => [
                'required',
                Rule::in([
                    'super_admin',
                    'admin_sucursal',
                    'recepcionista',
                    'entrenador',
                    'cliente',
                ]),
            ],
            'sucursal_id' => [
                Rule::requiredIf(fn () => $request->rol !== 'super_admin'),
                'nullable',
                'exists:sucursales,id',
            ],
            'peso' => ['nullable', 'numeric', 'min:1', 'max:300'],
            'altura' => ['nullable', 'numeric', 'min:0.50', 'max:2.50'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'especialidad' => ['nullable', 'string', 'max:100'],
        ]);

        DB::transaction(function () use ($request) {
            $sucursalId = $request->rol === 'super_admin'
                ? null
                : $request->sucursal_id;

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rol' => $request->rol,
                'sucursal_id' => $sucursalId,
            ]);

            $user->syncRoles([$request->rol]);

            if ($request->rol === 'cliente') {
                Cliente::create([
                    'user_id' => $user->id,
                    'sucursal_id' => $sucursalId,
                    'peso' => $request->peso,
                    'altura' => $request->altura,
                    'fecha_nacimiento' => $request->fecha_nacimiento,
                    'activo' => true,
                ]);
            }

            if ($request->rol === 'entrenador') {
                Entrenador::create([
                    'user_id' => $user->id,
                    'sucursal_id' => $sucursalId,
                    'telefono' => $request->telefono,
                    'especialidad' => $request->especialidad,
                    'activo' => true,
                ]);
            }
        });

        return redirect()
            ->route('usuario.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function show(string $id)
{
    $usuario = User::with(['roles', 'sucursal'])->findOrFail($id);

    $cliente = Cliente::with([
            'sucursal',
            'membresias' => function ($query) {
                $query->where('activa', true)
                      ->latest();
            }
        ])
        ->where('user_id', $usuario->id)
        ->first();

    $entrenador = Entrenador::with('sucursal')
        ->where('user_id', $usuario->id)
        ->first();

    return view('usuario.show', compact('usuario', 'cliente', 'entrenador'));
}

    public function edit(string $id)
    {
        $usuario = User::with(['roles', 'sucursal'])->findOrFail($id);
        $roles = Role::all();
        $sucursales = Sucursal::where('activa', true)->get();

        $cliente = Cliente::where('user_id', $usuario->id)->first();
        $entrenador = Entrenador::where('user_id', $usuario->id)->first();

        return view('usuario.edit', compact('usuario', 'roles', 'sucursales', 'cliente', 'entrenador'));
    }

    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email,' . $usuario->id],
            'password' => ['nullable', 'string', 'min:8'],
            'rol' => [
                'required',
                Rule::in([
                    'super_admin',
                    'admin_sucursal',
                    'recepcionista',
                    'entrenador',
                    'cliente',
                ]),
            ],
            'sucursal_id' => [
                Rule::requiredIf(fn () => $request->rol !== 'super_admin'),
                'nullable',
                'exists:sucursales,id',
            ],
            'peso' => ['nullable', 'numeric', 'min:1', 'max:300'],
            'altura' => ['nullable', 'numeric', 'min:0.50', 'max:2.50'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'especialidad' => ['nullable', 'string', 'max:100'],
        ]);

        if (auth()->id() === $usuario->id && $request->rol !== 'super_admin') {
            return redirect()
                ->back()
                ->withErrors(['rol' => 'No puedes quitarte a ti mismo el rol de super_admin.']);
        }

        DB::transaction(function () use ($request, $usuario) {
            $sucursalId = $request->rol === 'super_admin'
                ? null
                : $request->sucursal_id;

            $datosUsuario = [
                'name' => $request->name,
                'email' => $request->email,
                'rol' => $request->rol,
                'sucursal_id' => $sucursalId,
            ];

            if ($request->filled('password')) {
                $datosUsuario['password'] = Hash::make($request->password);
            }

            $usuario->update($datosUsuario);

            $usuario->syncRoles([$request->rol]);

            if ($request->rol === 'cliente') {
                Cliente::updateOrCreate(
                    ['user_id' => $usuario->id],
                    [
                        'sucursal_id' => $sucursalId,
                        'peso' => $request->peso,
                        'altura' => $request->altura,
                        'fecha_nacimiento' => $request->fecha_nacimiento,
                        'activo' => true,
                    ]
                );
            }

            if ($request->rol === 'entrenador') {
                Entrenador::updateOrCreate(
                    ['user_id' => $usuario->id],
                    [
                        'sucursal_id' => $sucursalId,
                        'telefono' => $request->telefono,
                        'especialidad' => $request->especialidad,
                        'activo' => true,
                    ]
                );
            }
        });

        return redirect()
            ->route('usuario.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            return redirect()
                ->route('usuario.index')
                ->with('error', 'No puedes eliminar el usuario con el que estás conectado.');
        }

        $user->delete();

        return redirect()
            ->route('usuario.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}