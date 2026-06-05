<x-layouts::app title="Usuarios">
    <div class="container">
        <h1>Usuarios</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('mensaje'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row align-items-center mb-3">
            <div class="col-md-8">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Buscar por nombre, email, rol o sucursal..."
                    data-buscador-tabla="#tablaUsuarios"
                    data-sin-resultados="#sinResultadosUsuarios">
            </div>

            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <a href="{{ route('usuario.create') }}" class="btn btn-success">
                    Crear Usuario
                </a>
            </div>
        </div>

        <table class="table table-bordered table-striped" id="tablaUsuarios">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Sucursal</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>

                        <td>
                            @if($usuario->rol)
                                <span class="badge bg-primary">
                                    {{ $usuario->rol }}
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    Sin rol
                                </span>
                            @endif
                        </td>

                        <td>{{ $usuario->sucursal->nombre ?? 'Global' }}</td>

                        <td>
                            <a href="{{ route('usuario.show', $usuario->id) }}"
                               class="btn btn-info btn-sm">
                                Detalles
                            </a>

                            <a href="{{ route('usuario.edit', $usuario->id) }}"
                               class="btn btn-warning btn-sm">
                                Editar
                            </a>

                            <form action="{{ route('usuario.destroy', $usuario->id) }}"
                                  method="POST"
                                  style="display:inline-block;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            No hay usuarios registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div id="sinResultadosUsuarios" class="alert alert-warning d-none">
            No se encontraron usuarios con ese criterio de búsqueda.
        </div>
    </div>

   
</x-layouts::app>