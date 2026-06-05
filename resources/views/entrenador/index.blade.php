<x-layouts::app title="Entrenadores">
    <div class="container">
        <h1>Entrenadores</h1>

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
                    placeholder="Buscar por nombre, correo, sucursal, teléfono, especialidad o estado..."
                    data-buscador-tabla="#tablaEntrenadores"
                    data-sin-resultados="#sinResultadosEntrenadores">
            </div>

            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <a href="{{ route('entrenador.create') }}" class="btn btn-success">
                    Registrar Entrenador
                </a>
            </div>
        </div>

        <table class="table table-bordered table-striped" id="tablaEntrenadores">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Sucursal</th>
                    <th>Teléfono</th>
                    <th>Especialidad</th>
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($entrenadores as $entrenador)
                    <tr>
                        <td>
                            @if($entrenador->foto_perfil)
                                <img
                                    src="{{ asset('storage/'.$entrenador->foto_perfil) }}"
                                    width="80"
                                    alt="Foto Perfil"
                                    class="img-thumbnail">
                            @else
                                Sin foto
                            @endif
                        </td>

                        <td>{{ $entrenador->id }}</td>
                        <td>{{ $entrenador->user->name ?? 'Sin nombre' }}</td>
                        <td>{{ $entrenador->user->email ?? 'Sin correo' }}</td>
                        <td>{{ $entrenador->sucursal->nombre ?? 'Sin sucursal' }}</td>
                        <td>{{ $entrenador->telefono ?? 'No registrado' }}</td>
                        <td>{{ $entrenador->especialidad ?? 'No registrada' }}</td>

                        <td>
                            @if($entrenador->activo)
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('entrenador.edit', $entrenador->id) }}"
                               class="btn btn-warning btn-sm">
                                Editar
                            </a>

                            <a href="{{ route('entrenador.show', $entrenador->id) }}"
                               class="btn btn-info btn-sm">
                                Detalles
                            </a>

                            <form action="{{ route('entrenador.destroy', $entrenador->id) }}"
                                  method="POST"
                                  style="display:inline-block;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Seguro que deseas eliminar este entrenador? También se eliminará su usuario de acceso.')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">
                            No hay entrenadores registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div id="sinResultadosEntrenadores" class="alert alert-warning d-none">
            No se encontraron entrenadores con ese criterio de búsqueda.
        </div>
    </div>

    
</x-layouts::app>