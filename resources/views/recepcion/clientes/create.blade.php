<x-layouts::app title="Alta rápida de cliente">
    <h1>Alta rápida de cliente</h1>

    <p class="text-muted">
        Sucursal: <strong>{{ $sucursal->nombre }}</strong>
    </p>

    <a href="{{ route('recepcion.clientes.index') }}" class="btn btn-secondary mb-3">
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

    <form action="{{ route('recepcion.clientes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nombre completo</label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-control"
                value="{{ old('name') }}"
                placeholder="Ejemplo: Juan Pérez"
                required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input
                type="email"
                name="email"
                id="email"
                class="form-control"
                value="{{ old('email') }}"
                placeholder="correo@ejemplo.com"
                required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña temporal</label>
            <input
                type="password"
                name="password"
                id="password"
                class="form-control"
                required>

            <small class="text-muted">
                El cliente podrá iniciar sesión con este correo y contraseña.
            </small>
        </div>

        <div class="mb-3">
            <label for="peso" class="form-label">Peso aproximado</label>
            <input
                type="number"
                step="0.01"
                min="1"
                name="peso"
                id="peso"
                class="form-control"
                value="{{ old('peso') }}"
                placeholder="Ejemplo: 70.5">
        </div>

        <div class="mb-3">
            <label for="altura" class="form-label">Altura aproximada</label>
            <input
                type="number"
                step="0.01"
                min="0.50"
                name="altura"
                id="altura"
                class="form-control"
                value="{{ old('altura') }}"
                placeholder="Ejemplo: 1.70">
        </div>

        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
            <input
                type="date"
                name="fecha_nacimiento"
                id="fecha_nacimiento"
                class="form-control"
                value="{{ old('fecha_nacimiento') }}">
        </div>

        <button type="submit" class="btn btn-primary">
            Registrar cliente
        </button>
    </form>
</x-layouts::app>