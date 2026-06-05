<x-layouts::app title="Clientes">
    <div class="container">
        <h1>Clientes</h1>

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
    placeholder="Buscar por nombre, correo, sucursal, membresía o estado..."
    data-buscador-tabla="#tablaClientes"
    data-sin-resultados="#sinResultadosClientes">
            </div>

            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <a href="{{ route('cliente.create') }}" class="btn btn-success">
                    Registrar Cliente
                </a>
            </div>
        </div>

        <table class="table table-bordered table-striped" id="tablaClientes">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Sucursal</th>
                    <th>Peso</th>
                    <th>Altura</th>
                    <th>Fecha Nacimiento</th>
                    <th>Activo</th>
                    <th>Membresía</th>
                    <th>Vencimiento</th>
                    <th>Estado Membresía</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($clientes as $cliente)
                    @php
                        $membresiaActiva = $cliente->membresias->first();
                    @endphp

                    <tr>
                        <td>
                            @if($cliente->foto_perfil)
                                <img
                                    src="{{ asset('storage/'.$cliente->foto_perfil) }}"
                                    width="80"
                                    alt="Foto Perfil"
                                    class="img-thumbnail">
                            @else
                                Sin foto
                            @endif
                        </td>

                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->user->name ?? 'Sin nombre' }}</td>
                        <td>{{ $cliente->user->email ?? 'Sin correo' }}</td>
                        <td>{{ $cliente->sucursal->nombre ?? 'Sin sucursal' }}</td>

                        <td>
                            {{ $cliente->peso ? $cliente->peso . ' kg' : 'No registrado' }}
                        </td>

                        <td>
                            {{ $cliente->altura ? $cliente->altura . ' m' : 'No registrada' }}
                        </td>

                        <td>
                            {{ $cliente->fecha_nacimiento ?? 'No registrada' }}
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
                                    <span class="badge bg-success">Vigente</span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        Vencida / No vigente
                                    </span>
                                @endif
                            @else
                                <span class="badge bg-danger">Sin acceso</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('cliente.edit', $cliente->id) }}"
                               class="btn btn-warning btn-sm">
                                Editar
                            </a>

                            <a href="{{ route('cliente.show', $cliente->id) }}"
                               class="btn btn-info btn-sm">
                                Detalles
                            </a>

                            <form action="{{ route('cliente.destroy', $cliente->id) }}"
                                  method="POST"
                                  style="display:inline-block;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Seguro que deseas eliminar este cliente? También se eliminará su usuario de acceso.')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="text-center">
                            No hay clientes registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div id="sinResultadosClientes" class="alert alert-warning d-none">
                No se encontraron clientes con ese criterio de búsqueda.
        </div>
    </div>

</x-layouts::app>