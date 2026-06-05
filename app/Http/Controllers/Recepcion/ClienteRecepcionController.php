<?php

namespace App\Http\Controllers\Recepcion;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClienteRecepcionController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        /*
         * Recepcionista: solo ve clientes de su sucursal.
         * Superadmin: puede probar usando la primera sucursal activa.
         */
        $sucursalId = $user->sucursal_id;

        if (!$sucursalId && $user->hasRole('super_admin')) {
            $sucursalId = Sucursal::where('activa', true)->orderBy('id')->value('id');
        }

        $sucursal = Sucursal::find($sucursalId);

        $clientes = Cliente::with([
                'user',
                'sucursal',
                'membresias' => function ($query) {
                    $query->where('activa', true)
                          ->latest();
                }
            ])
            ->where('sucursal_id', $sucursalId)
            ->latest()
            ->get();

        return view('recepcion.clientes.index', compact('clientes', 'sucursal'));
    }

    public function create()
    {
        $user = auth()->user();

        $sucursalId = $user->sucursal_id;

        if (!$sucursalId && $user->hasRole('super_admin')) {
            $sucursalId = Sucursal::where('activa', true)->orderBy('id')->value('id');
        }

        $sucursal = Sucursal::findOrFail($sucursalId);

        return view('recepcion.clientes.create', compact('sucursal'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $sucursalId = $user->sucursal_id;

        if (!$sucursalId && $user->hasRole('super_admin')) {
            $sucursalId = Sucursal::where('activa', true)->orderBy('id')->value('id');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'peso' => ['nullable', 'numeric', 'min:1', 'max:300'],
            'altura' => ['nullable', 'numeric', 'min:0.50', 'max:2.50'],
            'fecha_nacimiento' => ['nullable', 'date'],
        ]);

        DB::transaction(function () use ($request, $sucursalId) {
            $nuevoUsuario = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rol' => 'cliente',
                'sucursal_id' => $sucursalId,
            ]);

            $nuevoUsuario->syncRoles(['cliente']);

            Cliente::create([
                'user_id' => $nuevoUsuario->id,
                'sucursal_id' => $sucursalId,
                'peso' => $request->peso,
                'altura' => $request->altura,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'activo' => true,
            ]);
        });

        return redirect()
            ->route('recepcion.clientes.index')
            ->with('mensaje', 'Cliente registrado correctamente en la sucursal.');
    }
}