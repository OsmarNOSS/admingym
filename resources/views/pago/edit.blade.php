<x-layouts::app title="Editar Pago">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <div class="container">
        <h2 class="mb-4">Editar Pago #{{ $pago->id }}</h2>
        <form action="{{ route('pago.update', $pago->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label class="form-label">Cliente</label>
                <input type="text" class="form-control" value="{{ $pago->cliente->user->name ?? 'N/A' }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Membresía</label>
                <input type="text" class="form-control" value="{{ ucfirst($pago->membresia->tipo ?? 'N/A') }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Sucursal</label>
                <select name="sucursal_id" class="form-control" required>
                    @foreach($sucursales as $sucursal)
                        <option value="{{ $sucursal->id }}" {{ $pago->sucursal_id == $sucursal->id ? 'selected' : '' }}>
                            {{ $sucursal->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Monto</label>
                <input type="number" step="0.01" name="monto" class="form-control" value="{{ $pago->monto }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Método de pago</label>
                <select name="metodo_pago" class="form-control" required>
                    @foreach(['efectivo', 'tarjeta', 'transferencia'] as $metodo)
                        <option value="{{ $metodo }}" {{ $pago->metodo_pago == $metodo ? 'selected' : '' }}>
                            {{ ucfirst($metodo) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Concepto</label>
                <input type="text" name="concepto" class="form-control" value="{{ $pago->concepto }}">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('pago.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-layouts::app>