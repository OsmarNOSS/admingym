<x-layouts::app title="Mi Perfil">
    <div class="container">
        <h1>Mi Perfil</h1>

        @if(session('mensaje'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <a href="{{ route('cliente-panel.perfil.edit') }}" class="btn btn-warning mb-3">
                Editar Perfil
            </a>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <h4>Foto de perfil</h4>

                        @if($cliente->foto_perfil)
                            <img
                                src="{{ asset('storage/'.$cliente->foto_perfil) }}"
                                alt="Foto de perfil"
                                class="img-thumbnail"
                                style="max-width: 250px;">
                        @else
                            <div class="alert alert-secondary">
                                Sin fotografía registrada.
                            </div>
                        @endif
                    </div>

                    <div class="col-md-8">
                        <h4>Datos personales</h4>

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
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>