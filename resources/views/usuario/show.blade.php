<x-layouts::app title="Detalles Usuario">
    <div class="container">
        <h1>Detalles del Usuario</h1>

        <a href="{{ route('usuario.index') }}" class="btn btn-secondary mb-3">
            Regresar
        </a>

        <div class="card mb-3">
            <div class="card-body">
                <h4>Datos generales</h4>

                <div class="mb-3">
                    <strong>ID:</strong>
                    <p>{{ $usuario->id }}</p>
                </div>

                <div class="mb-3">
                    <strong>Nombre:</strong>
                    <p>{{ $usuario->name }}</p>
                </div>

                <div class="mb-3">
                    <strong>Email:</strong>
                    <p>{{ $usuario->email }}</p>
                </div>

                <div class="mb-3">
                    <strong>Rol users:</strong>
                    <p>{{ $usuario->rol ?? 'Sin rol' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Sucursal:</strong>
                    <p>{{ $usuario->sucursal->nombre ?? 'Global / sin sucursal' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Fecha de creación:</strong>
                    <p>{{ $usuario->created_at ? $usuario->created_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Última actualización:</strong>
                    <p>{{ $usuario->updated_at ? $usuario->updated_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                </div>
            </div>
        </div>

        @if($cliente)
            <div class="card mb-3">
                <div class="card-body">
                    <h4>Perfil de Cliente</h4>

                    <div class="mb-3">
                        <strong>ID Cliente:</strong>
                        <p>{{ $cliente->id }}</p>
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
                        <strong>Fecha nacimiento:</strong>
                        <p>{{ $cliente->fecha_nacimiento ?? 'No registrada' }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Estado:</strong>
                        <p>{{ $cliente->activo ? 'Activo' : 'Inactivo' }}</p>
                    </div>
                     
                    {{--  agrego membresia para los casos de clientes --}}
                    @php
    $membresiaActiva = $cliente->membresias->first();
@endphp

<hr>

<h5>Membresía activa</h5>

<div class="mb-3">
    <strong>Tipo:</strong>
    <p>
        @if($membresiaActiva)
            <span class="badge bg-primary text-uppercase">
                {{ $membresiaActiva->tipo }}
            </span>
        @else
            <span class="badge bg-secondary">
                Sin membresía activa
            </span>
        @endif
    </p>
</div>

@if($membresiaActiva)
    <div class="mb-3">
        <strong>Fecha de inicio:</strong>
        <p>{{ $membresiaActiva->fecha_inicio ? $membresiaActiva->fecha_inicio->format('d/m/Y') : 'No registrada' }}</p>
    </div>

    <div class="mb-3">
        <strong>Fecha de vencimiento:</strong>
        <p>{{ $membresiaActiva->fecha_fin ? $membresiaActiva->fecha_fin->format('d/m/Y') : 'No registrada' }}</p>
    </div>

    <div class="mb-3">
        <strong>Estado de membresía:</strong>
        <p>
            @if($membresiaActiva->estaVigente())
                <span class="badge bg-success">Vigente</span>
            @else
                <span class="badge bg-warning text-dark">Vencida / No vigente</span>
            @endif
        </p>
    </div>

    <div class="mb-3">
        <strong>Sucursal de contratación:</strong>
        <p>{{ $membresiaActiva->sucursal->nombre ?? 'Sin sucursal' }}</p>
    </div>
@endif

                </div>
            </div>
        @endif

        @if($entrenador)
            <div class="card mb-3">
                <div class="card-body">
                    <h4>Perfil de Entrenador</h4>

                    <div class="mb-3">
                        <strong>ID Entrenador:</strong>
                        <p>{{ $entrenador->id }}</p>
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
                </div>
            </div>
        @endif

        <a href="{{ route('usuario.edit', $usuario->id) }}" class="btn btn-warning">
            Editar Usuario
        </a>
    </div>
</x-layouts::app>