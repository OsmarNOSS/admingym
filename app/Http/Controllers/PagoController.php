<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Cliente;
use App\Models\Membresia;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with([
                'cliente.user',
                'membresia',
                'sucursal',
                'registradoPor'
            ])
            ->latest()
            ->get();

        return view('pago.index', compact('pagos'));
    }

    public function create()
{
    $clientes = Cliente::with([
        'user',
        'membresias' => function ($q) {
            $q->where('activa', true);
        }
    ])->get();

    $sucursales = Sucursal::all();

    $membresiasJson = $clientes->mapWithKeys(fn($c) => [
        $c->id => $c->membresias->map(function ($m) {
            $meses = $m->fecha_inicio->diffInMonths($m->fecha_fin);

            if ($meses <= 1) {
                $periodo = 'mensual';
            } elseif ($meses <= 3) {
                $periodo = 'trimestral';
            } else {
                $periodo = 'anual';
            }

            return [
                'id' => $m->id,
                'tipo' => ucfirst($m->tipo),
                'sucursal_id' => $m->sucursal_id,
                'periodo' => $periodo,
            ];
        })
    ]);

    return view('pago.create', compact('clientes', 'sucursales', 'membresiasJson'));
}

    public function store(Request $request)
{
    $request->validate([
        'cliente_id' => ['required', 'exists:clientes,id'],
        'membresia_id' => ['required', 'exists:membresias,id'],
        'sucursal_id' => ['required', 'exists:sucursales,id'],
        'periodo' => ['required', 'in:mensual,trimestral,anual'],
        'monto' => ['required', 'numeric', 'min:0'],
        'metodo_pago' => ['required', 'in:efectivo,tarjeta,transferencia'],
        'concepto' => ['nullable', 'string', 'max:255'],
    ]);

    // Verificar que la membresía pertenece al cliente
    Membresia::where('id', $request->membresia_id)
        ->where('cliente_id', $request->cliente_id)
        ->firstOrFail();

    // Solo bloqueamos si ya existe un pago para esta membresía
    $yaExistePago = Pago::where('cliente_id', $request->cliente_id)
        ->where('membresia_id', $request->membresia_id)
        ->exists();

    if ($yaExistePago) {
        return redirect()
            ->back()
            ->withErrors([
                'membresia_id' => 'Este cliente ya tiene un pago registrado para esta membresía.',
            ])
            ->withInput();
    }

    Pago::create([
        'cliente_id' => $request->cliente_id,
        'membresia_id' => $request->membresia_id,
        'sucursal_id' => $request->sucursal_id,
        'registrado_por' => auth()->id(),
        'monto' => $request->monto,
        'metodo_pago' => $request->metodo_pago,
        'concepto' => $request->concepto,
    ]);

    return redirect()
        ->route('pago.index')
        ->with('mensaje', 'Pago registrado correctamente.');
}

    public function show($id)
    {
        $pago = Pago::with([
                'cliente.user',
                'membresia',
                'sucursal',
                'registradoPor'
            ])
            ->findOrFail($id);

        return view('pago.show', compact('pago'));
    }

    public function edit($id)
    {
        $pago = Pago::with([
                'cliente.user',
                'membresia',
                'sucursal'
            ])
            ->findOrFail($id);

        $sucursales = Sucursal::where('activa', true)->get();

        return view('pago.edit', compact('pago', 'sucursales'));
    }

    public function update(Request $request, $id)
    {
        $pago = Pago::findOrFail($id);

        $request->validate([
            'monto' => ['required', 'numeric', 'min:0'],
            'metodo_pago' => ['required', 'in:efectivo,tarjeta,transferencia'],
            'concepto' => ['nullable', 'string', 'max:255'],
        ]);

        $pago->update([
            'monto' => $request->monto,
            'metodo_pago' => $request->metodo_pago,
            'concepto' => $request->concepto,
        ]);

        return redirect()
            ->route('pago.index')
            ->with('mensaje', 'Pago actualizado correctamente.');
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();

        return redirect()
            ->route('pago.index')
            ->with('mensaje', 'Pago eliminado correctamente.');
    }
}