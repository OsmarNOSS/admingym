<x-layouts::app title="Detalles Entrenador">

    <h1>Detalles del Entrenador</h1>

    <div class="mb-3">
        <strong>Nombre:</strong>
        <p>{{ $entrenador->user->name ?? 'Sin nombre' }}</p>
    </div>

    <div class="mb-3">
        <strong>Correo:</strong>
        <p>{{ $entrenador->user->email ?? 'Sin correo' }}</p>
    </div>

    <div class="mb-3">
        <strong>Sucursal:</strong>
        <p>{{ $entrenador->sucursal->nombre ?? 'Sin sucursal asignada' }}</p>
    </div>

    <div class="mb-3">
        <strong>Teléfono:</strong>
        <p>{{ $entrenador->telefono ?? 'No registrado' }}</p>
    </div>

    <div class="mb-3">
        <strong>Especialidad:</strong>
        <p>{{ $entrenador->especialidad ?? 'No registrada' }}</p>
    </div>

    <div class="mb-3">
        <strong>Estado:</strong>
        <p>{{ $entrenador->activo ? 'Activo' : 'Inactivo' }}</p>
    </div>

    <div class="mb-3">
        <strong>Foto de perfil:</strong>
        <br>

        @if($entrenador->foto_perfil)
            <img
                src="{{ asset('storage/'.$entrenador->foto_perfil) }}"
                alt="Foto de perfil"
                class="img-fluid rounded"
                style="max-width: 300px;"
            >
        @else
            <p>Sin fotografía</p>
        @endif
    </div>

    <a href="{{ route('entrenador.index') }}" class="btn btn-secondary">
        Regresar
    </a>

</x-layouts::app>