<x-layouts::app title="Detalles Membresía">
    <div class="container">
        <h1>Detalles de Membresía</h1>

        <a href="{{ route('membresia.index') }}" class="btn btn-secondary mb-3">
            Regresar
        </a>

        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <strong>ID Membresía:</strong>
                    <p>{{ $membresia->id }}</p>
                </div>

                <div class="mb-3">
                    <strong>Cliente:</strong>
                    <p>{{ $membresia->cliente->user->name ?? 'Sin cliente' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Correo del cliente:</strong>
                    <p>{{ $membresia->cliente->user->email ?? 'Sin correo' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Sucursal de contratación:</strong>
                    <p>{{ $membresia->sucursal->nombre ?? 'Sin sucursal' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Tipo:</strong>
                    <p>
                        <span class="badge bg-primary text-uppercase">
                            {{ $membresia->tipo }}
                        </span>
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Fecha de inicio:</strong>
                    <p>{{ $membresia->fecha_inicio ? $membresia->fecha_inicio->format('d/m/Y') : 'No registrada' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Fecha de vencimiento:</strong>
                    <p>{{ $membresia->fecha_fin ? $membresia->fecha_fin->format('d/m/Y') : 'No registrada' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Días restantes:</strong>
                    <p>{{ $membresia->diasRestantes() }}</p>
                </div>

                <div class="mb-3">
                    <strong>Estado:</strong>
                    <p>
                        @if($membresia->estaVigente())
                            <span class="badge bg-success">Vigente</span>
                        @elseif($membresia->activa)
                            <span class="badge bg-warning text-dark">Activa no vigente</span>
                        @else
                            <span class="badge bg-secondary">Inactiva</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('membresia.edit', $membresia->id) }}" class="btn btn-warning">
                Editar Membresía
            </a>
        </div>
    </div>
</x-layouts::app>