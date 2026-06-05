<x-layouts::app title="Registrar Asistencia">
    <div class="container">
        <h1>Registrar Asistencia</h1>

        <p class="text-muted">
            Sucursal: <strong>{{ $sucursal->nombre }}</strong>
        </p>

        <a href="{{ route('asistencias.index') }}" class="btn btn-secondary mb-3">
            Ver asistencias de hoy
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

        <form action="{{ route('asistencias.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="cliente_id" class="form-label">Cliente</label>
                <select name="cliente_id" id="cliente_id" class="form-control" required>
                    <option value="">Seleccione un cliente</option>

                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}">
                            {{ $cliente->user->name ?? 'Sin nombre' }} —
                            {{ $cliente->user->email ?? 'Sin correo' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                Validar y registrar entrada
            </button>
        </form>
    </div>
</x-layouts::app>