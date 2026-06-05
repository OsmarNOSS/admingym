<x-layouts::app title="Mi Entrenador">
    <div class="container">
        <h1>Mi Entrenador</h1>

        @if($asignacion && $asignacion->entrenador)
            @php
                $entrenador = $asignacion->entrenador;
            @endphp

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <h4>Foto</h4>

                            @if($entrenador->foto_perfil)
                                <img
                                    src="{{ asset('storage/'.$entrenador->foto_perfil) }}"
                                    alt="Foto del entrenador"
                                    class="img-thumbnail"
                                    style="max-width: 250px;">
                            @else
                                <div class="alert alert-secondary">
                                    Sin fotografía registrada.
                                </div>
                            @endif
                        </div>

                        <div class="col-md-8">
                            <h4>Datos del entrenador</h4>

                            <div class="mb-3">
                                <strong>Nombre:</strong>
                                <p>{{ $entrenador->user->name ?? 'Sin nombre' }}</p>
                            </div>

                            <div class="mb-3">
                                <strong>Especialidad:</strong>
                                <p>{{ $entrenador->especialidad ?? 'No registrada' }}</p>
                            </div>

                            <div class="mb-3">
                                <strong>Teléfono de contacto:</strong>
                                <p>{{ $entrenador->telefono ?? 'No registrado' }}</p>
                            </div>

                            <div class="mb-3">
                                <strong>Correo de contacto:</strong>
                                <p>{{ $entrenador->user->email ?? 'No registrado' }}</p>
                            </div>

                            <div class="mb-3">
                                <strong>Sucursal:</strong>
                                <p>{{ $entrenador->sucursal->nombre ?? 'Sin sucursal' }}</p>
                            </div>

                            <div class="mb-3">
                                <strong>Fecha de asignación:</strong>
                                <p>
                                    {{ $asignacion->fecha_asignacion ? $asignacion->fecha_asignacion->format('d/m/Y') : 'No registrada' }}
                                </p>
                            </div>

                            <div class="mb-3">
                                <strong>Estado de asignación:</strong>
                                <p>
                                    @if($asignacion->activo)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning">
                Aún no tienes un entrenador asignado.
            </div>
        @endif
    </div>
</x-layouts::app>