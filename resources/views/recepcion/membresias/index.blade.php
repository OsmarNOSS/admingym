<x-layouts::app title="Recepción - Membresías">
    <div class="container">
        <h1>Membresías de recepción</h1>

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
                    placeholder="Buscar por cliente, correo, tipo, inicio, vencimiento o estado..."
                    data-buscador-tabla="#tablaRecepcionMembresias"
                    data-sin-resultados="#sinResultadosRecepcionMembresias">
            </div>

            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <a href="{{ route('recepcion.membresias.create') }}" class="btn btn-success">
                    Registrar Membresía
                </a>
            </div>
        </div>

        <table class="table table-bordered table-striped" id="tablaRecepcionMembresias">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Correo</th>
                    <th>Tipo</th>
                    <th>Inicio</th>
                    <th>Vencimiento</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
                @forelse($membresias as $membresia)
                    <tr>
                        <td>{{ $membresia->id }}</td>
                        <td>{{ $membresia->cliente->user->name ?? 'Sin cliente' }}</td>
                        <td>{{ $membresia->cliente->user->email ?? 'Sin correo' }}</td>

                        <td>
                            <span class="badge bg-primary text-uppercase">
                                {{ $membresia->tipo }}
                            </span>
                        </td>

                        <td>
                            {{ $membresia->fecha_inicio ? $membresia->fecha_inicio->format('d/m/Y') : 'No registrada' }}
                        </td>

                        <td>
                            {{ $membresia->fecha_fin ? $membresia->fecha_fin->format('d/m/Y') : 'No registrada' }}
                        </td>

                        <td>
                            @if($membresia->estaVigente())
                                <span class="badge bg-success">Vigente</span>
                            @elseif($membresia->activa)
                                <span class="badge bg-warning text-dark">Activa no vigente</span>
                            @else
                                <span class="badge bg-secondary">Inactiva</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            No hay membresías registradas en esta sucursal.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div id="sinResultadosRecepcionMembresias" class="alert alert-warning d-none">
            No se encontraron membresías con ese criterio de búsqueda.
        </div>
    </div>
</x-layouts::app>