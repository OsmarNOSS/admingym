<h1>{{ $modo }} Membresía</h1>

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

<div class="mb-3">
    <label for="cliente_busqueda" class="form-label">Cliente</label>

    <input
        list="clientes"
        id="cliente_busqueda"
        class="form-control"
        placeholder="Buscar cliente por nombre o correo..."
        autocomplete="off"
        required>

    <datalist id="clientes">
        @foreach($clientes as $cliente)
            <option
                value="{{ ($cliente->user->name ?? 'Sin nombre') . ' — ' . ($cliente->user->email ?? 'Sin correo') }}"
                data-id="{{ $cliente->id }}">
            </option>
        @endforeach
    </datalist>

    <input
        type="hidden"
        name="cliente_id"
        id="cliente_id"
        value="{{ old('cliente_id', $membresia->cliente_id ?? '') }}">

    <small class="text-muted">
        Selecciona un cliente de la lista para que se registre correctamente.
    </small>
</div>

<div class="mb-3">
    <label for="sucursal_id" class="form-label">Sucursal de contratación</label>
    <select name="sucursal_id" id="sucursal_id" class="form-control" required>
        <option value="">Seleccione una sucursal</option>

        @foreach($sucursales as $sucursal)
            <option value="{{ $sucursal->id }}"
                {{ old('sucursal_id', $membresia->sucursal_id ?? '') == $sucursal->id ? 'selected' : '' }}>
                {{ $sucursal->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="tipo" class="form-label">Tipo de membresía</label>
    <select name="tipo" id="tipo" class="form-control" required>
        <option value="">Seleccione tipo</option>

        <option value="basic" {{ old('tipo', $membresia->tipo ?? '') == 'basic' ? 'selected' : '' }}>
            Basic - Solo sucursal de origen
        </option>

        <option value="premium" {{ old('tipo', $membresia->tipo ?? '') == 'premium' ? 'selected' : '' }}>
            Premium - Todas las sucursales
        </option>

        <option value="vip" {{ old('tipo', $membresia->tipo ?? '') == 'vip' ? 'selected' : '' }}>
            VIP - Todas las sucursales + rutinas premium
        </option>
    </select>
</div>

<div class="mb-3">
    <label for="periodo" class="form-label">Período</label>
    <select id="periodo" class="form-control" required>
        <option value="">Seleccione un período</option>
        <option value="mensual">Mensual</option>
        <option value="trimestral">Trimestral</option>
        <option value="anual">Anual</option>
    </select>

    <small class="text-muted">
        El período calcula automáticamente la fecha de vencimiento y el precio estimado.
    </small>
</div>

<div class="mb-3">
    <label for="precio" class="form-label">Precio estimado</label>
    <input
        type="text"
        id="precio"
        class="form-control"
        readonly
        placeholder="Se calcula automáticamente">
</div>

<div class="mb-3">
    <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
    <input
        type="date"
        name="fecha_inicio"
        id="fecha_inicio"
        class="form-control"
        value="{{ old('fecha_inicio', isset($membresia->fecha_inicio) ? $membresia->fecha_inicio->format('Y-m-d') : '') }}"
        required>
</div>

<div class="mb-3">
    <label for="fecha_fin" class="form-label">Fecha de vencimiento</label>
    <input
        type="date"
        name="fecha_fin"
        id="fecha_fin"
        class="form-control"
        value="{{ old('fecha_fin', isset($membresia->fecha_fin) ? $membresia->fecha_fin->format('Y-m-d') : '') }}"
        required
        readonly>

    <small class="text-muted">
        La fecha de vencimiento se calcula automáticamente según el período seleccionado.
    </small>
</div>

<div class="mb-3 form-check">
    <input
        type="checkbox"
        name="activa"
        id="activa"
        class="form-check-input"
        {{ old('activa', $membresia->activa ?? true) ? 'checked' : '' }}>

    <label for="activa" class="form-check-label">
        Membresía activa
    </label>
</div>

<div class="alert alert-info">
    Si marcas esta membresía como activa, cualquier otra membresía activa del mismo cliente se desactivará automáticamente.
</div>

<input type="submit" value="{{ $modo }}" class="btn btn-primary">

<script>
    const precios = {
        basic: {
            mensual: 299,
            trimestral: 799,
            anual: 2499
        },
        premium: {
            mensual: 499,
            trimestral: 1299,
            anual: 3999
        },
        vip: {
            mensual: 799,
            trimestral: 1999,
            anual: 5999
        }
    };

    const meses = {
        mensual: 1,
        trimestral: 3,
        anual: 12
    };

    const clienteBusquedaInput = document.getElementById('cliente_busqueda');
    const clienteIdInput = document.getElementById('cliente_id');
    const opcionesClientes = document.querySelectorAll('#clientes option');

    const tipoInput = document.getElementById('tipo');
    const periodoInput = document.getElementById('periodo');
    const fechaInicioInput = document.getElementById('fecha_inicio');
    const fechaFinInput = document.getElementById('fecha_fin');
    const precioInput = document.getElementById('precio');

    function actualizarClienteId() {
        const valor = clienteBusquedaInput.value;
        clienteIdInput.value = '';

        opcionesClientes.forEach(function (opcion) {
            if (opcion.value === valor) {
                clienteIdInput.value = opcion.dataset.id;
            }
        });
    }

    function cargarClienteActual() {
        const clienteIdActual = clienteIdInput.value;

        if (!clienteIdActual) {
            return;
        }

        opcionesClientes.forEach(function (opcion) {
            if (opcion.dataset.id == clienteIdActual) {
                clienteBusquedaInput.value = opcion.value;
            }
        });
    }

    function calcularMembresia() {
        const tipo = tipoInput.value;
        const periodo = periodoInput.value;
        const inicio = fechaInicioInput.value;

        if (!tipo || !periodo) {
            precioInput.value = '';
            return;
        }

        if (precios[tipo] && precios[tipo][periodo]) {
            precioInput.value = '$' + precios[tipo][periodo].toLocaleString('es-MX') + ' MXN';
        }

        if (!inicio) {
            return;
        }

        const partes = inicio.split('-');

        const fechaInicio = new Date(
            Number(partes[0]),
            Number(partes[1]) - 1,
            Number(partes[2])
        );

        fechaInicio.setMonth(fechaInicio.getMonth() + meses[periodo]);

        const year = fechaInicio.getFullYear();
        const month = String(fechaInicio.getMonth() + 1).padStart(2, '0');
        const day = String(fechaInicio.getDate()).padStart(2, '0');

        fechaFinInput.value = `${year}-${month}-${day}`;
    }

    clienteBusquedaInput.addEventListener('input', actualizarClienteId);
    tipoInput.addEventListener('change', calcularMembresia);
    periodoInput.addEventListener('change', calcularMembresia);
    fechaInicioInput.addEventListener('change', calcularMembresia);

    cargarClienteActual();
    calcularMembresia();
</script>