<x-layouts::app title="Rutinas">
    <div class="container">
        <h1>Rutinas disponibles</h1>

        @if(session('mensaje'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row align-items-center mb-3">
            <div class="col-md-8">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Buscar por nombre, nivel, tipo, estado o descripción..."
                    data-buscador-tabla="#tablaRutinas"
                    data-sin-resultados="#sinResultadosRutinas">
            </div>

            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <a href="{{ route('entrenador-panel.rutinas.create') }}" class="btn btn-success">
                    Crear Rutina
                </a>
            </div>
        </div>

        <table class="table table-bordered table-striped" id="tablaRutinas">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Nivel</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($rutinas as $rutina)
                    <tr>
                        <td>
                            @if($rutina->foto_portada)
                                <img
                                    src="{{ asset('storage/'.$rutina->foto_portada) }}"
                                    alt="Foto rutina"
                                    class="img-thumbnail"
                                    style="max-width: 90px;">
                            @else
                                Sin foto
                            @endif
                        </td>

                        <td>{{ $rutina->nombre }}</td>

                        <td>
                            <span class="badge bg-secondary">
                                {{ ucfirst($rutina->nivel) }}
                            </span>
                        </td>

                        <td>
                            @if($rutina->es_vip)
                                <span class="badge bg-dark">VIP</span>
                            @else
                                <span class="badge bg-primary">Normal</span>
                            @endif
                        </td>

                        <td>
                            @if($rutina->activa)
                                <span class="badge bg-success">Activa</span>
                            @else
                                <span class="badge bg-danger">Inactiva</span>
                            @endif
                        </td>

                        <td>{{ $rutina->descripcion ?? 'Sin descripción' }}</td>

                        <td>
                            <a href="{{ route('entrenador-panel.rutinas.edit', $rutina->id) }}"
                               class="btn btn-warning btn-sm">
                                Editar
                            </a>

                            <form action="{{ route('entrenador-panel.rutinas.destroy', $rutina->id) }}"
                                  method="POST"
                                  style="display:inline-block;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Seguro que deseas desactivar esta rutina?')">
                                    Desactivar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            No hay rutinas registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div id="sinResultadosRutinas" class="alert alert-warning d-none">
        No se encontraron membresías con ese criterio de búsqueda.
        </div>
    </div>

    
</x-layouts::app>