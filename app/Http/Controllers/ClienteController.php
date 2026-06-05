<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
     $clientes = Cliente::with(['user','sucursal','membresias' => function ($query) {
            $query->where('activa', true)->latest();
        }
        ])->get();
        return view('cliente.index', compact('clientes'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sucursales = Sucursal::where('activa', true)->get();

        return view('cliente.create', compact('sucursales'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'sucursal_id' => ['required', 'exists:sucursales,id'],
            'peso' => ['nullable', 'numeric', 'min:1', 'max:300'],
            'altura' => ['nullable', 'numeric', 'min:0.50', 'max:2.50'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'foto_perfil' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        DB::transaction(function () use ($request) {
            $fotoPath = null;

            if ($request->hasFile('foto_perfil')) {
                $fotoPath = $request->file('foto_perfil')->store('clientes', 'public');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rol' => 'cliente',
                'sucursal_id' => $request->sucursal_id,
            ]);

            $user->syncRoles(['cliente']);

            Cliente::create([
                'user_id' => $user->id,
                'sucursal_id' => $request->sucursal_id,
                'peso' => $request->peso,
                'altura' => $request->altura,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'activo' => $request->has('activo') ? 1 : 0,
                'foto_perfil' => $fotoPath,
            ]);
        });

        return redirect()
            ->route('cliente.index')
            ->with('mensaje', 'Cliente agregado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cliente = Cliente::with(['user', 'sucursal'])->findOrFail($id);

        return view('cliente.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cliente = Cliente::with(['user', 'sucursal'])->findOrFail($id);
        $sucursales = Sucursal::where('activa', true)->get();

        return view('cliente.edit', compact('cliente', 'sucursales'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::with('user')->findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email,' . $cliente->user_id],
            'password' => ['nullable', 'string', 'min:8'],
            'sucursal_id' => ['required', 'exists:sucursales,id'],
            'peso' => ['nullable', 'numeric', 'min:1', 'max:300'],
            'altura' => ['nullable', 'numeric', 'min:0.50', 'max:2.50'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'foto_perfil' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        DB::transaction(function () use ($request, $cliente) {
            $cliente->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'sucursal_id' => $request->sucursal_id,
                'rol' => 'cliente',
            ]);

            if ($request->filled('password')) {
                $cliente->user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            $datosCliente = [
                'sucursal_id' => $request->sucursal_id,
                'peso' => $request->peso,
                'altura' => $request->altura,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'activo' => $request->has('activo') ? 1 : 0,
            ];

            if ($request->hasFile('foto_perfil')) {
                if ($cliente->foto_perfil) {
                    Storage::disk('public')->delete($cliente->foto_perfil);
                }

                $datosCliente['foto_perfil'] = $request->file('foto_perfil')->store('clientes', 'public');
            }

            $cliente->update($datosCliente);
        });

        return redirect()
            ->route('cliente.index')
            ->with('mensaje', 'Cliente actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cliente = Cliente::with('user')->findOrFail($id);

        if ($cliente->foto_perfil) {
            Storage::disk('public')->delete($cliente->foto_perfil);
        }

        if ($cliente->user) {
            $cliente->user->delete();
        } else {
            $cliente->delete();
        }

        return redirect()
            ->route('cliente.index')
            ->with('mensaje', 'Cliente eliminado con éxito.');
    }
}