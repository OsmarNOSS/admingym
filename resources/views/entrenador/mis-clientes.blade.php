<x-layouts::app title="Mis Clientes">
    <div class="container">
        <h1>Mis Clientes</h1>

        @if(session('mensaje'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="mb-3">
            <a href="{{ route('entrenador-panel.elegir-clientes') }}" class="btn btn-success">
                Elegir Clientes
            </a>

            <a href="{{ route('entrenador-panel.rutinas.index') }}" class="btn btn-primary">
                Ver Rutinas
            </a>
        </div>

        <form action="{{ route('entrenador-panel.mis-clientes') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input
                    type="text"
                    name="buscar"
                    class="form-control"
                    placeholder="Buscar cliente por nombre o correo"
                    value="{{ $busqueda ?? '' }}">

                <button type="submit" class="btn btn-dark">
                    Buscar
                </button>

                <a href="{{ route('entrenador-panel.mis-clientes') }}" class="btn btn-secondary">
                    Limpiar
                </a>
            </div>
        </form>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Correo</th>
                    <th>Sucursal</th>
                    <th>Membresía</th>
                    <th>Estado membresía</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($clientes as $cliente)
                    @php
                        $membresiaActiva = $cliente->membresias->first();
                    @endphp

                    <tr>
                        <td>{{ $cliente->user->name ?? 'Sin nombre' }}</td>
                        <td>{{ $cliente->user->email ?? 'Sin correo' }}</td>
                        <td>{{ $cliente->sucursal->nombre ?? 'Sin sucursal' }}</td>

                        <td>
                            @if($membresiaActiva)
                                <span class="badge bg-primary text-uppercase">
                                    {{ $membresiaActiva->tipo }}
                                </span>
                            @else
                                <span class="badge bg-secondary">Sin membresía</span>
                            @endif
                        </td>

                        <td>
                            @if($membresiaActiva && $membresiaActiva->estaVigente())
                                <span class="badge bg-success">Vigente</span>
                            @elseif($membresiaActiva)
                                <span class="badge bg-warning text-dark">No vigente</span>
                            @else
                                <span class="badge bg-danger">Sin acceso</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('entrenador-panel.asignar-rutina', $cliente->id) }}"
                               class="btn btn-primary btn-sm">
                                Asignar Rutina
                            </a>

                            <a href="{{ route('entrenador-panel.rutinas-cliente', $cliente->id) }}"
                               class="btn btn-info btn-sm">
                                Ver Rutinas
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            No se encontraron clientes asignados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts::app>