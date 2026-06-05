<x-layouts::app title="Editar Mi Perfil">
    <div class="container">
        <h1>Editar Mi Perfil</h1>

        <a href="{{ route('entrenador-panel.perfil') }}" class="btn btn-secondary mb-3">
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

        <div class="card">
            <div class="card-body">
                <form action="{{ route('entrenador-panel.perfil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input
                            type="text"
                            class="form-control"
                            value="{{ $entrenador->user->name ?? '' }}"
                            readonly>
                        <small class="text-muted">
                            El nombre solo puede ser modificado por administración.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Correo</label>
                        <input
                            type="email"
                            class="form-control"
                            value="{{ $entrenador->user->email ?? '' }}"
                            readonly>
                        <small class="text-muted">
                            El correo solo puede ser modificado por administración.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sucursal</label>
                        <input
                            type="text"
                            class="form-control"
                            value="{{ $entrenador->sucursal->nombre ?? 'Sin sucursal' }}"
                            readonly>
                        <small class="text-muted">
                            La sucursal solo puede ser modificada por administración.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input
                            type="text"
                            name="telefono"
                            id="telefono"
                            class="form-control"
                            value="{{ old('telefono', $entrenador->telefono) }}"
                            placeholder="Ejemplo: 7151234567">
                    </div>

                    <div class="mb-3">
                        <label for="especialidad" class="form-label">Especialidad</label>
                        <input
                            type="text"
                            name="especialidad"
                            id="especialidad"
                            class="form-control"
                            value="{{ old('especialidad', $entrenador->especialidad) }}"
                            placeholder="Ejemplo: Funcional, pesas, cardio, rehabilitación">
                    </div>

                    <div class="mb-3">
                        <label for="foto_perfil" class="form-label">Foto de perfil</label>

                        @if($entrenador->foto_perfil)
                            <div class="mb-2">
                                <img
                                    src="{{ asset('storage/'.$entrenador->foto_perfil) }}"
                                    alt="Foto actual"
                                    class="img-thumbnail"
                                    style="max-width: 180px;">
                            </div>
                        @endif

                        <input
                            type="file"
                            name="foto_perfil"
                            id="foto_perfil"
                            class="form-control"
                            accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Guardar cambios
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>