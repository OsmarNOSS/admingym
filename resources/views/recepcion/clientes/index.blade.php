<x-layouts::app title="Recepción - Clientes">
    <div class="container">
        <h1>Clientes </h1>

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
                    placeholder="Buscar por nombre, correo, peso, altura, membresía o estado..."
                    data-buscador-tabla="#tablaRecepcionClientes"
                    data-sin-resultados="#sinResultadosRecepcionClientes">
            </div>

            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <a href="{{ route('recepcion.clientes.create') }}" class="btn btn-success">
                    Alta rápida de cliente
                </a>
            </div>
        </div>

        <table class="table table-bordered table-striped" id="tablaRecepcionClientes">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Peso</th>
                    <th>Altura</th>
                    <th>Activo</th>
                    <th>Membresía</th>
                    <th>Vencimiento</th>
                    <th>Estado membresía</th>
                </tr>
            </thead>

            <tbody>
                @forelse($clientes as $cliente)
                    @php
                        $membresiaActiva = $cliente->membresias->first();
                    @endphp

                    <tr>
                        <td>{{ $cliente->id }}</td>

                        <td>{{ $cliente->user->name ?? 'Sin usuario' }}</td>

                        <td>{{ $cliente->user->email ?? 'Sin correo' }}</td>

                        <td>
                            {{ $cliente->peso ? $cliente->peso . ' kg' : 'No registrado' }}
                        </td>

                        <td>
                            {{ $cliente->altura ? $cliente->altura . ' m' : 'No registrada' }}
                        </td>

                        <td>
                            @if($cliente->activo)
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>

                        <td>
                            @if($membresiaActiva)
                                <span class="badge bg-primary text-uppercase">
                                    {{ $membresiaActiva->tipo }}
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    Sin membresía
                                </span>
                            @endif
                        </td>

                        <td>
                            @if($membresiaActiva && $membresiaActiva->fecha_fin)
                                {{ $membresiaActiva->fecha_fin->format('d/m/Y') }}
                            @else
                                No registrada
                            @endif
                        </td>

                        <td>
                            @if($membresiaActiva)
                                @if($membresiaActiva->estaVigente())
                                    <span class="badge bg-success">
                                        Vigente
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        Vencida / No vigente
                                    </span>
                                @endif
                            @else
                                <span class="badge bg-danger">
                                    Sin acceso
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">
                            No hay clientes registrados en esta sucursal.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div id="sinResultadosRecepcionClientes" class="alert alert-warning d-none">
            No se encontraron clientes con ese criterio de búsqueda.
        </div>
    </div>
</x-layouts::app>