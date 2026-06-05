<x-layouts::app title="Asistencias del día">
    <div class="container">
        <h1>Asistencias del día</h1>

        @if($sucursal)
            <p class="text-muted">
                Sucursal: <strong>{{ $sucursal->nombre }}</strong>
            </p>
        @endif

        @if(session('mensaje'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row align-items-center mb-3">
            <div class="col-md-8">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Buscar por hora, cliente, correo, membresía, acceso, motivo o registró..."
                    data-buscador-tabla="#tablaAsistencias"
                    data-sin-resultados="#sinResultadosAsistencias">
            </div>

            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <a href="{{ route('asistencias.create') }}" class="btn btn-success">
                    Registrar entrada
                </a>
            </div>
        </div>

        <table class="table table-bordered table-striped" id="tablaAsistencias">
            <thead>
                <tr>
                    <th>Hora</th>
                    <th>Cliente</th>
                    <th>Correo</th>
                    <th>Membresía</th>
                    <th>Acceso</th>
                    <th>Motivo</th>
                    <th>Registró</th>
                </tr>
            </thead>

            <tbody>
                @forelse($asistencias as $asistencia)
                    <tr>
                        <td>{{ $asistencia->fecha_entrada->format('H:i:s') }}</td>
                        <td>{{ $asistencia->cliente->user->name ?? 'Sin cliente' }}</td>
                        <td>{{ $asistencia->cliente->user->email ?? 'Sin correo' }}</td>

                        <td>
                            @if($asistencia->membresia)
                                <span class="badge bg-primary text-uppercase">
                                    {{ $asistencia->membresia->tipo }}
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    Sin membresía
                                </span>
                            @endif
                        </td>

                        <td>
                            @if($asistencia->acceso_permitido)
                                <span class="badge bg-success">Permitido</span>
                            @else
                                <span class="badge bg-danger">Denegado</span>
                            @endif
                        </td>

                        <td>{{ $asistencia->motivo_denegacion ?? 'Acceso correcto' }}</td>
                        <td>{{ $asistencia->registradoPor->name ?? 'No disponible' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            No hay asistencias registradas hoy.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div id="sinResultadosAsistencias" class="alert alert-warning d-none">
            No se encontraron asistencias con ese criterio de búsqueda.
        </div>
    </div>
</x-layouts::app>