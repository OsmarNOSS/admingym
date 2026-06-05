<x-layouts::app title="Editar Mi Perfil">
    <div class="container">
        <h1>Editar Mi Perfil</h1>

        <a href="{{ route('cliente-panel.perfil') }}" class="btn btn-secondary mb-3">
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
                <form action="{{ route('cliente-panel.perfil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input
                            type="text"
                            class="form-control"
                            value="{{ $cliente->user->name ?? '' }}"
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
                            value="{{ $cliente->user->email ?? '' }}"
                            readonly>
                        <small class="text-muted">
                            El correo solo puede ser modificado por administración.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="peso" class="form-label">Peso (kg)</label>
                        <input
                            type="number"
                            step="0.01"
                            min="1"
                            max="300"
                            name="peso"
                            id="peso"
                            class="form-control"
                            value="{{ old('peso', $cliente->peso) }}">
                    </div>

                    <div class="mb-3">
                        <label for="altura" class="form-label">Altura (m)</label>
                        <input
                            type="number"
                            step="0.01"
                            min="0.50"
                            max="2.50"
                            name="altura"
                            id="altura"
                            class="form-control"
                            value="{{ old('altura', $cliente->altura) }}">
                    </div>

                    <div class="mb-3">
                        <label for="foto_perfil" class="form-label">Foto de perfil</label>

                        @if($cliente->foto_perfil)
                            <div class="mb-2">
                                <img
                                    src="{{ asset('storage/'.$cliente->foto_perfil) }}"
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