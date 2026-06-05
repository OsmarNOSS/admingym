<x-layouts::app title="Acceso Denegado">
    <div class="container">
        <div class="alert alert-danger">
            <h1>Acceso denegado</h1>
            <p class="mb-0">
                No se permitió la entrada del cliente por la siguiente razón:
            </p>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <strong>Cliente:</strong>
                    <p>{{ $asistencia->cliente->user->name ?? 'Sin cliente' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Correo:</strong>
                    <p>{{ $asistencia->cliente->user->email ?? 'Sin correo' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Sucursal:</strong>
                    <p>{{ $asistencia->sucursal->nombre ?? 'Sin sucursal' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Membresía:</strong>
                    <p>
                        @if($asistencia->membresia)
                            <span class="badge bg-primary text-uppercase">
                                {{ $asistencia->membresia->tipo }}
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                Sin membresía
                            </span>
                        @endif
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Motivo:</strong>
                    <p class="text-danger">
                        {{ $asistencia->motivo_denegacion }}
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Fecha y hora:</strong>
                    <p>{{ $asistencia->fecha_entrada->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('asistencias.create') }}" class="btn btn-primary">
                Registrar otra entrada
            </a>

            <a href="{{ route('asistencias.index') }}" class="btn btn-secondary">
                Ver historial del día
            </a>
        </div>
    </div>
</x-layouts::app>