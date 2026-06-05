<x-layouts::app title="Asignar Rutina">
    <div class="container">
        <h1>Asignar Rutina</h1>

        <a href="{{ route('entrenador-panel.mis-clientes') }}" class="btn btn-secondary mb-3">
            Regresar
        </a>

        <a href="{{ route('entrenador-panel.rutinas.create') }}" class="btn btn-success mb-3">
            Crear Nueva Rutina
        </a>

        <div class="card mb-3">
            <div class="card-body">
                <h4>Cliente</h4>

                <p><strong>Nombre:</strong> {{ $cliente->user->name ?? 'Sin nombre' }}</p>
                <p><strong>Correo:</strong> {{ $cliente->user->email ?? 'Sin correo' }}</p>

                <p>
                    <strong>Membresía:</strong>
                    @if(!$membresiaActiva)
    <div class="alert alert-danger">
        Este cliente no tiene una membresía activa. No se le puede asignar una rutina.
    </div>
@elseif(!$membresiaActiva->estaVigente())
    <div class="alert alert-warning">
        Este cliente tiene una membresía registrada, pero no está vigente. No se le puede asignar una rutina.
    </div>
@endif
                    @if($membresiaActiva)
                        <span class="badge bg-primary text-uppercase">
                            {{ $membresiaActiva->tipo }}
                        </span>
                    @else
                        <span class="badge bg-secondary">Sin membresía</span>
                    @endif
                </p>
            </div>
        </div>

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

        <form action="{{ route('entrenador-panel.guardar-rutina', $cliente->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="rutina_id" class="form-label">Rutina</label>
                <select name="rutina_id" id="rutina_id" class="form-control" required>
                    <option value="">Seleccione una rutina</option>

                    @foreach($rutinas as $rutina)
                        <option value="{{ $rutina->id }}" {{ old('rutina_id') == $rutina->id ? 'selected' : '' }}>
                            {{ $rutina->nombre }}
                            —
                            {{ ucfirst($rutina->nivel) }}
                            @if($rutina->es_vip)
                                — VIP
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha_asignacion" class="form-label">Fecha de asignación</label>
                <input
                    type="date"
                    name="fecha_asignacion"
                    id="fecha_asignacion"
                    class="form-control"
                    value="{{ old('fecha_asignacion', now()->format('Y-m-d')) }}"
                    required>
            </div>

           <button
                type="submit"
                class="btn btn-primary"
                {{ !$membresiaActiva || !$membresiaActiva->estaVigente() ? 'disabled' : '' }}>
                Asignar Rutina
            </button>
        </form>
    </div>
</x-layouts::app>