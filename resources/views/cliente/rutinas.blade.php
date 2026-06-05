<x-layouts::app title="Mis Rutinas">
    <div class="container">
        <h1>Mis Rutinas</h1>

        @if($membresiaActiva)
            <div class="alert alert-info">
                Membresía actual:
                <strong class="text-uppercase">{{ $membresiaActiva->tipo }}</strong>
            </div>
        @else
            <div class="alert alert-warning">
                No tienes una membresía activa registrada.
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Rutina</th>
                    <th>Nivel</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Entrenador</th>
                    <th>Fecha asignación</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
                @forelse($rutinasAsignadas as $asignacion)
                    @php
                        $rutina = $asignacion->rutina;
                        $bloqueadaVip = $rutina && $rutina->es_vip && !$tieneVip;
                    @endphp

                    <tr>
                        <td>
                            @if($rutina && $rutina->foto_portada)
                                <img
                                    src="{{ asset('storage/'.$rutina->foto_portada) }}"
                                    alt="Foto rutina"
                                    class="img-thumbnail"
                                    style="max-width: 90px;">
                            @else
                                Sin foto
                            @endif
                        </td>

                        <td>{{ $rutina->nombre ?? 'Sin rutina' }}</td>
                        <td>{{ $rutina->nivel ?? 'No registrado' }}</td>

                        <td>
                            @if($rutina && $rutina->es_vip)
                                <span class="badge bg-dark">VIP</span>
                            @else
                                <span class="badge bg-primary">Normal</span>
                            @endif
                        </td>

                        <td>
                            @if($bloqueadaVip)
                                <span class="text-danger">
                                    Rutina bloqueada. Requiere membresía VIP vigente.
                                </span>
                            @else
                                {{ $rutina->descripcion ?? 'Sin descripción' }}
                            @endif
                        </td>

                        <td>{{ $asignacion->entrenador->user->name ?? 'No registrado' }}</td>

                        <td>
                            {{ $asignacion->fecha_asignacion ? $asignacion->fecha_asignacion->format('d/m/Y') : 'No registrada' }}
                        </td>

                        <td>
                            @if($bloqueadaVip)
                                <span class="badge bg-danger">Bloqueada VIP</span>
                            @else
                                <span class="badge bg-success">Disponible</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            No tienes rutinas asignadas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts::app>