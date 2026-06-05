<x-layouts::app title="Detalles Sucursal">

<h1>Detalles de la Sucursal</h1>

<div class="mb-3">
    <strong>Nombre del gimnasio:</strong>
    <p>{{ $sucursal->nombre }}</p>
</div>

<div class="mb-3">
    <strong>Dirección:</strong>
    <p>{{ $sucursal->direccion }}</p>
</div>

<div class="mb-3">
    <strong>Teléfono:</strong>
    <p>{{ $sucursal->telefono }}</p>
</div>

<div class="mb-3">
    <strong>Capacidad:</strong>
    <p>{{ $sucursal->capacidad }} personas</p>
</div>

<div class="mb-3">
    <strong>Horario:</strong>
    <p>
        {{ $sucursal->hora_apertura }}
        -
        {{ $sucursal->hora_cierre }}
    </p>
</div>

<div class="mb-3">
    <strong>Estado:</strong>
    <p>
        {{ $sucursal->activa ? 'Activa' : 'Inactiva' }}
    </p>
</div>

<div class="mb-3">
    <strong>Foto de portada:</strong>
    <br>

    @if($sucursal->foto_portada)
        <img
            src="{{ asset('storage/'.$sucursal->foto_portada) }}"
            alt="Foto de portada"
            class="img-fluid rounded"
            style="max-width: 300px;"
        >
    @else
        <p>Sin imagen</p>
    @endif
</div>

<a href="{{ route('sucursal.index') }}" class="btn btn-secondary">
    Regresar
</a>
</x-layouts::app>
