<x-layouts::app title="Registrar Membresía">
    <div class="container">
        <h1>Registrar Membresía</h1>

        <p class="text-muted">
            Sucursal: <strong>{{ $sucursal->nombre }}</strong>
        </p>

        <a href="{{ route('recepcion.membresias.index') }}" class="btn btn-secondary mb-3">
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

        <form action="{{ route('recepcion.membresias.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="cliente_id" class="form-label">Cliente</label>
                <select name="cliente_id" id="cliente_id" class="form-control" required>
                    <option value="">Seleccione un cliente</option>

                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->user->name ?? 'Sin nombre' }} —
                            {{ $cliente->user->email ?? 'Sin correo' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de membresía</label>
                <select name="tipo" id="tipo" class="form-control" required>
                    <option value="">Seleccione tipo</option>
                    <option value="basic" {{ old('tipo') == 'basic' ? 'selected' : '' }}>
                        Basic - Solo sucursal de origen
                    </option>
                    <option value="premium" {{ old('tipo') == 'premium' ? 'selected' : '' }}>
                        Premium - Todas las sucursales
                    </option>
                    <option value="vip" {{ old('tipo') == 'vip' ? 'selected' : '' }}>
                        VIP - Todas las sucursales + rutinas premium
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                <input
                    type="date"
                    name="fecha_inicio"
                    id="fecha_inicio"
                    class="form-control"
                    value="{{ old('fecha_inicio', now()->format('Y-m-d')) }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="fecha_fin" class="form-label">Fecha de vencimiento</label>
                <input
                    type="date"
                    name="fecha_fin"
                    id="fecha_fin"
                    class="form-control"
                    value="{{ old('fecha_fin') }}"
                    required>
            </div>

            <div class="alert alert-info">
                Al registrar esta membresía, cualquier otra membresía activa del cliente se desactivará automáticamente.
            </div>

            <button type="submit" class="btn btn-primary">
                Registrar Membresía
            </button>
        </form>
    </div>
</x-layouts::app>