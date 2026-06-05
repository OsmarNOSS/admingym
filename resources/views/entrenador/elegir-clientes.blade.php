<x-layouts::app title="Elegir Clientes">
    <div class="container">
        <h1>Elegir Clientes</h1>

        <p class="text-muted">
            Sucursal del entrenador:
            <strong>{{ $entrenador->sucursal->nombre ?? 'Sin sucursal' }}</strong>
        </p>

        <a href="{{ route('entrenador-panel.mis-clientes') }}" class="btn btn-secondary mb-3">
            Regresar
        </a>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Corrige los siguientes errores:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('entrenador-panel.guardar-clientes') }}" method="POST">
            @csrf

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Seleccionar</th>
                        <th>Cliente</th>
                        <th>Correo</th>
                        <th>Sucursal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($clientes as $cliente)
                        <tr>
                            <td>
                                <input
                                    type="checkbox"
                                    name="clientes[]"
                                    value="{{ $cliente->id }}"
                                    {{ in_array($cliente->id, $clientesAsignadosIds) ? 'checked' : '' }}>
                            </td>

                            <td>{{ $cliente->user->name ?? 'Sin nombre' }}</td>
                            <td>{{ $cliente->user->email ?? 'Sin correo' }}</td>
                            <td>{{ $cliente->sucursal->nombre ?? 'Sin sucursal' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                No hay clientes activos en tu sucursal.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">
                Guardar selección
            </button>
        </form>
    </div>
</x-layouts::app>