<x-layouts::app title="Mi Membresía">
    <div class="container">
        <h1>Mi Membresía</h1>

        <div class="card">
            <div class="card-body">
                <h4>Estado de membresía</h4>

                @if($membresiaActiva)
                    <div class="mb-3">
                        <strong>Tipo:</strong>
                        <p>
                            <span class="badge bg-primary text-uppercase">
                                {{ $membresiaActiva->tipo }}
                            </span>
                        </p>
                    </div>

                    <div class="mb-3">
                        <strong>Sucursal de contratación:</strong>
                        <p>{{ $membresiaActiva->sucursal->nombre ?? 'Sin sucursal' }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Fecha de inicio:</strong>
                        <p>{{ $membresiaActiva->fecha_inicio ? $membresiaActiva->fecha_inicio->format('d/m/Y') : 'No registrada' }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Fecha de vencimiento:</strong>
                        <p>{{ $membresiaActiva->fecha_fin ? $membresiaActiva->fecha_fin->format('d/m/Y') : 'No registrada' }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Días restantes:</strong>
                        <p>{{ $membresiaActiva->diasRestantes() }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Estado:</strong>
                        <p>
                            @if($membresiaActiva->estaVigente())
                                <span class="badge bg-success">Vigente</span>
                            @else
                                <span class="badge bg-warning text-dark">Vencida / No vigente</span>
                            @endif
                        </p>
                    </div>

                    <div class="alert alert-info">
                        La membresía Basic solo permite acceso a la sucursal donde fue contratada.
                        Las membresías Premium y VIP permiten acceso a cualquier sucursal.
                    </div>
                @else
                    <div class="alert alert-danger">
                        No tienes una membresía activa registrada.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts::app>