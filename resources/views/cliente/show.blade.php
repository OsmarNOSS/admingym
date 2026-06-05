<x-layouts::app title="Detalles Cliente">
    <div class="container">
        <h1>Detalles del Cliente</h1>

        <a href="{{ route('cliente.index') }}" class="btn btn-secondary mb-3">
            Regresar
        </a>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <strong>Foto de perfil:</strong>
                        <br><br>

                        @if($cliente->foto_perfil)
                            <img
                                src="{{ asset('storage/'.$cliente->foto_perfil) }}"
                                alt="Foto de perfil"
                                class="img-fluid rounded img-thumbnail"
                                style="max-width: 250px;">
                        @else
                            <p>Sin fotografía</p>
                        @endif
                    </div>

                    <div class="col-md-8">
                        <div class="mb-3">
                            <strong>ID Cliente:</strong>
                            <p>{{ $cliente->id }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Nombre:</strong>
                            <p>{{ $cliente->user->name ?? 'Sin nombre' }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Correo:</strong>
                            <p>{{ $cliente->user->email ?? 'Sin correo' }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Sucursal:</strong>
                            <p>{{ $cliente->sucursal->nombre ?? 'Sin sucursal asignada' }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Peso:</strong>
                            <p>{{ $cliente->peso ? $cliente->peso . ' kg' : 'No registrado' }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Altura:</strong>
                            <p>{{ $cliente->altura ? $cliente->altura . ' m' : 'No registrada' }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Fecha de nacimiento:</strong>
                            <p>{{ $cliente->fecha_nacimiento ?? 'No registrada' }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Estado:</strong>
                            <p>
                                @if($cliente->activo)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <strong>Fecha de registro:</strong>
                            <p>{{ $cliente->created_at ? $cliente->created_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('cliente.edit', $cliente->id) }}" class="btn btn-warning">
                Editar Cliente
            </a>
        </div>
    </div>
</x-layouts::app>