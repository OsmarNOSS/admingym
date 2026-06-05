<x-layouts::app title="Crear Usuario">
    <div class="container">
        <h2>Crear Usuario</h2>

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

        <form action="{{ route('usuario.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email') }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select name="rol" id="rol" class="form-control" required>
                    <option value="">Seleccione un rol</option>

                    @foreach($roles as $rol)
                        <option value="{{ $rol->name }}" {{ old('rol') == $rol->name ? 'selected' : '' }}>
                            {{ $rol->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3" id="campo-sucursal">
                <label class="form-label">Sucursal</label>
                <select name="sucursal_id" class="form-control">
                    <option value="">Sin sucursal / Super Admin</option>

                    @foreach($sucursales as $sucursal)
                        <option value="{{ $sucursal->id }}" {{ old('sucursal_id') == $sucursal->id ? 'selected' : '' }}>
                            {{ $sucursal->nombre }}
                        </option>
                    @endforeach
                </select>

                <small class="text-muted">
                    Obligatoria para admin_sucursal, recepcionista, entrenador y cliente.
                </small>
            </div>

            <div id="campos-cliente" style="display:none;">
                <hr>
                <h5>Datos del cliente</h5>

                <div class="mb-3">
                    <label class="form-label">Peso</label>
                    <input
                        type="number"
                        step="0.01"
                        name="peso"
                        class="form-control"
                        value="{{ old('peso') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Altura</label>
                    <input
                        type="number"
                        step="0.01"
                        name="altura"
                        class="form-control"
                        value="{{ old('altura') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha de nacimiento</label>
                    <input
                        type="date"
                        name="fecha_nacimiento"
                        class="form-control"
                        value="{{ old('fecha_nacimiento') }}">
                </div>
            </div>

            <div id="campos-entrenador" style="display:none;">
                <hr>
                <h5>Datos del entrenador</h5>

                <div class="mb-3">
                    <label class="form-label">Teléfono</label>
                    <input
                        type="text"
                        name="telefono"
                        class="form-control"
                        value="{{ old('telefono') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Especialidad</label>
                    <input
                        type="text"
                        name="especialidad"
                        class="form-control"
                        value="{{ old('especialidad') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                Guardar
            </button>

            <a href="{{ route('usuario.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </form>
    </div>

    <script>
        const rolSelect = document.getElementById('rol');
        const camposCliente = document.getElementById('campos-cliente');
        const camposEntrenador = document.getElementById('campos-entrenador');

        function actualizarCampos() {
            const rol = rolSelect.value;

            camposCliente.style.display = rol === 'cliente' ? 'block' : 'none';
            camposEntrenador.style.display = rol === 'entrenador' ? 'block' : 'none';
        }

        rolSelect.addEventListener('change', actualizarCampos);
        actualizarCampos();
    </script>
</x-layouts::app>