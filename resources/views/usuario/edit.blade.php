<x-layouts::app title="Editar Usuario">
    <div class="container">
        <h2>Editar Usuario</h2>

        <a href="{{ route('usuario.index') }}" class="btn btn-secondary mb-3">
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

        <form action="{{ route('usuario.update', $usuario->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    value="{{ old('name', $usuario->name) }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control"
                    value="{{ old('email', $usuario->email) }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">
                    Nueva contraseña
                    <small class="text-muted">(déjala vacía si no quieres cambiarla)</small>
                </label>

                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    placeholder="Opcional al editar">
            </div>

            <div class="mb-3">
                <label for="rol" class="form-label">Rol</label>
                <select name="rol" id="rol" class="form-control" required>
                    <option value="">Seleccione un rol</option>

                    @foreach($roles as $rol)
                        <option value="{{ $rol->name }}"
                            {{ old('rol', $usuario->rol) == $rol->name ? 'selected' : '' }}>
                            {{ $rol->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3" id="campo-sucursal">
                <label for="sucursal_id" class="form-label">Sucursal</label>
                <select name="sucursal_id" id="sucursal_id" class="form-control">
                    <option value="">Sin sucursal / Super Admin</option>

                    @foreach($sucursales as $sucursal)
                        <option value="{{ $sucursal->id }}"
                            {{ old('sucursal_id', $usuario->sucursal_id) == $sucursal->id ? 'selected' : '' }}>
                            {{ $sucursal->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="campos-cliente" style="display:none;">
                <hr>
                <h5>Datos del cliente</h5>

                <div class="mb-3">
                    <label for="peso" class="form-label">Peso</label>
                    <input
                        type="number"
                        step="0.01"
                        min="1"
                        max="300"
                        name="peso"
                        id="peso"
                        class="form-control"
                        value="{{ old('peso', $cliente->peso ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="altura" class="form-label">Altura</label>
                    <input
                        type="number"
                        step="0.01"
                        min="0.50"
                        max="2.50"
                        name="altura"
                        id="altura"
                        class="form-control"
                        value="{{ old('altura', $cliente->altura ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                    <input
                        type="date"
                        name="fecha_nacimiento"
                        id="fecha_nacimiento"
                        class="form-control"
                        value="{{ old('fecha_nacimiento', $cliente->fecha_nacimiento ?? '') }}">
                </div>
            </div>

            <div id="campos-entrenador" style="display:none;">
                <hr>
                <h5>Datos del entrenador</h5>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input
                        type="text"
                        name="telefono"
                        id="telefono"
                        class="form-control"
                        value="{{ old('telefono', $entrenador->telefono ?? '') }}"
                        placeholder="Ejemplo: 7151234567">
                </div>

                <div class="mb-3">
                    <label for="especialidad" class="form-label">Especialidad</label>
                    <input
                        type="text"
                        name="especialidad"
                        id="especialidad"
                        class="form-control"
                        value="{{ old('especialidad', $entrenador->especialidad ?? '') }}"
                        placeholder="Ejemplo: Funcional, pesas, cardio">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                Actualizar
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
        const campoSucursal = document.getElementById('campo-sucursal');

        function actualizarCampos() {
            const rol = rolSelect.value;

            camposCliente.style.display = rol === 'cliente' ? 'block' : 'none';
            camposEntrenador.style.display = rol === 'entrenador' ? 'block' : 'none';

            if (rol === 'super_admin') {
                campoSucursal.style.display = 'none';
            } else {
                campoSucursal.style.display = 'block';
            }
        }

        rolSelect.addEventListener('change', actualizarCampos);
        actualizarCampos();
    </script>
</x-layouts::app>