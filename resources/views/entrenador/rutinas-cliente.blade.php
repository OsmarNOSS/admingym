<x-layouts::app title="Rutinas del Cliente">
    <div class="container">
        <h1>Rutinas Asignadas</h1>

        <a href="{{ route('entrenador-panel.mis-clientes') }}" class="btn btn-secondary mb-3">
            Regresar
        </a>

        <a href="{{ route('entrenador-panel.asignar-rutina', $cliente->id) }}" class="btn btn-primary mb-3">
            Añadir Rutina
        </a>

        @if(session('mensaje'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card mb-3">
            <div class="card-body">
                <h4>Cliente</h4>
                <p><strong>Nombre:</strong> {{ $cliente->user->name ?? 'Sin nombre' }}</p>
                <p><strong>Correo:</strong> {{ $cliente->user->email ?? 'Sin correo' }}</p>
                <p><strong>Sucursal:</strong> {{ $cliente->sucursal->nombre ?? 'Sin sucursal' }}</p>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Rutina</th>
                    <th>Nivel</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Fecha asignación</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($rutinasAsignadas as $asignacion)
                    @php
                        $rutina = $asignacion->rutina;
                    @endphp

                    <tr>
                        <td>
                            @if($rutina && $rutina->foto_portada)
                                <img
                                    src="{{ asset('storage/'.$rutina->foto_portada) }}"
                                    alt="Foto rutina"
                                    class="img-thumbnail"
                                    style="max-width: 90px;">
                            @else
                                Sin foto
                            @endif
                        </td>

                        <td>{{ $rutina->nombre ?? 'Sin rutina' }}</td>
                        <td>{{ $rutina->nivel ?? 'No registrado' }}</td>

                        <td>
                            @if($rutina && $rutina->es_vip)
                                <span class="badge bg-dark">VIP</span>
                            @else
                                <span class="badge bg-primary">Normal</span>
                            @endif
                        </td>

                        <td>{{ $rutina->descripcion ?? 'Sin descripción' }}</td>

                        <td>
                            {{ $asignacion->fecha_asignacion ? $asignacion->fecha_asignacion->format('d/m/Y') : 'No registrada' }}
                        </td>

                        <td>
                            <form action="{{ route('entrenador-panel.quitar-rutina', [$cliente->id, $asignacion->id]) }}"
                                  method="POST"
                                  style="display:inline-block;">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Seguro que deseas quitar esta rutina al cliente?')">
                                    Quitar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            Este cliente no tiene rutinas asignadas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts::app>