<x-layouts::app title="Detalles del Pago">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <div class="container">
        <a href="{{ route('pago.index') }}" class="btn btn-secondary mb-3">Regresar</a>
        <h2 class="mb-4">Detalles del Pago #{{ $pago->id }}</h2>
        <div class="card">
            <div class="card-body">
                <p><strong>Cliente:</strong> {{ $pago->cliente->user->name ?? 'N/A' }}</p>
                <p><strong>Correo:</strong> {{ $pago->cliente->user->email ?? 'N/A' }}</p>
                <p><strong>Membresía:</strong> {{ ucfirst($pago->membresia->tipo ?? 'N/A') }}</p>
                <p><strong>Sucursal:</strong> {{ $pago->sucursal->nombre ?? 'N/A' }}</p>
                <p><strong>Monto:</strong> ${{ number_format($pago->monto, 2) }} MXN</p>
                <p><strong>Método de pago:</strong> {{ ucfirst($pago->metodo_pago) }}</p>
                <p><strong>Concepto:</strong> {{ $pago->concepto ?? 'N/A' }}</p>
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y H:i') }}</p>
                <p><strong>Registrado por:</strong> {{ $pago->registradoPor->name ?? 'N/A' }}</p>
            </div>
        </div>
        <a href="{{ route('pago.edit', $pago->id) }}" class="btn btn-warning mt-3">Editar</a>
    </div>
</x-layouts::app>