<x-layouts::app title="Membresías">
    <div class="container">
        <h1>Membresías</h1>

        @if(Session::has('mensaje'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row align-items-center mb-3">
            <div class="col-md-8">
                <input
                type="text"
                class="form-control"
                placeholder="Buscar por cliente, correo, sucursal, tipo, vencimiento o estado..."
                data-buscador-tabla="#tablaMembresias"
                data-sin-resultados="#sinResultadosMembresias">
            </div>

            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <a href="{{ route('membresia.create') }}" class="btn btn-success">
                    Registrar Membresía
                </a>
            </div>
        </div>

        <table class="table table-bordered table-striped" id="tablaMembresias">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Correo</th>
                    <th>Sucursal</th>
                    <th>Tipo</th>
                    <th>Inicio</th>
                    <th>Vencimiento</th>
                    <th>Días restantes</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($membresias as $membresia)
                    <tr>
                        <td>{{ $membresia->id }}</td>
                        <td>{{ $membresia->cliente->user->name ?? 'Sin cliente' }}</td>
                        <td>{{ $membresia->cliente->user->email ?? 'Sin correo' }}</td>
                        <td>{{ $membresia->sucursal->nombre ?? 'Sin sucursal' }}</td>

                        <td>
                            <span class="badge bg-primary text-uppercase">
                                {{ $membresia->tipo }}
                            </span>
                        </td>

                        <td>
                            {{ $membresia->fecha_inicio ? $membresia->fecha_inicio->format('d/m/Y') : 'N/A' }}
                        </td>

                        <td>
                            {{ $membresia->fecha_fin ? $membresia->fecha_fin->format('d/m/Y') : 'N/A' }}
                        </td>

                        <td>
                            @php
                                $dias = $membresia->diasRestantes();
                            @endphp

                            @if($dias < 0)
                                <span class="badge bg-danger">Vencida</span>
                            @elseif($dias <= 7)
                                <span class="badge bg-warning text-dark">{{ $dias }} días</span>
                            @else
                                <span class="badge bg-success">{{ $dias }} días</span>
                            @endif
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

                        <td>
                            <a href="{{ route('membresia.edit', $membresia->id) }}"
                               class="btn btn-warning btn-sm">
                                Editar
                            </a>

                            <a href="{{ route('membresia.show', $membresia->id) }}"
                               class="btn btn-info btn-sm">
                                Detalles
                            </a>

                            <form action="{{ route('membresia.destroy', $membresia->id) }}"
                                  method="POST"
                                  style="display:inline-block;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Seguro que deseas eliminar esta membresía?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">
                            No hay membresías registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div id="sinResultadosMembresias" class="alert alert-warning d-none">
            No se encontraron membresías con ese criterio de búsqueda.
        </div>
    </div>

    
</x-layouts::app>