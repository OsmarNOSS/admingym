<x-layouts::app title="Registrar Pago">
    <div class="container">
        <h2 class="mb-4">Registrar Pago</h2>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Corrige los siguientes errores:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('pago.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Cliente</label>

                <input
                    list="clientes-list"
                    id="cliente_busqueda"
                    class="form-control"
                    placeholder="Buscar cliente..."
                    value="">

                <datalist id="clientes-list">
                    @foreach($clientes as $cliente)
                        <option
                            value="{{ $cliente->user->name ?? 'Sin nombre' }} — {{ $cliente->user->email ?? 'Sin correo' }}"
                            data-id="{{ $cliente->id }}">
                        </option>
                    @endforeach
                </datalist>

                <input type="hidden" name="cliente_id" id="cliente_id" value="{{ old('cliente_id') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Membresía activa</label>
                <select name="membresia_id" id="membresia_id" class="form-control" required>
                    <option value="">Seleccione primero un cliente</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Sucursal</label>
                <select name="sucursal_id" id="sucursal_id" class="form-control" required>
                    <option value="">Seleccione una sucursal</option>
                    @foreach($sucursales as $sucursal)
                        <option value="{{ $sucursal->id }}">
                            {{ $sucursal->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Período</label>
                <select name="periodo" id="periodo" class="form-control" required>
                    <option value="">Seleccione un período</option>
                    <option value="mensual">Mensual</option>
                    <option value="trimestral">Trimestral</option>
                    <option value="anual">Anual</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Monto</label>
                <input type="number" step="0.01" name="monto" id="monto" class="form-control" value="{{ old('monto') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Método de pago</label>
                <select name="metodo_pago" class="form-control" required>
                    <option value="efectivo" {{ old('metodo_pago') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                    <option value="tarjeta" {{ old('metodo_pago') == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                    <option value="transferencia" {{ old('metodo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Concepto</label>
                <input type="text" name="concepto" class="form-control" placeholder="Ej: Mensualidad enero" value="{{ old('concepto') }}">
            </div>

            <button type="submit" class="btn btn-primary">Registrar Pago</button>
            <a href="{{ route('pago.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <div id="membresias-data" data-json="{{ json_encode($membresiasJson, JSON_HEX_QUOT | JSON_HEX_APOS | JSON_HEX_AMP) }}"></div>

<div id="clientes-data" data-json="{{ json_encode(
    $clientes->map(fn($c) => [
        'id' => $c->id,
        'label' => ($c->user->name ?? 'Sin nombre') . ' — ' . ($c->user->email ?? 'Sin correo')
    ]),
    JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS
) }}"></div>

   <script>
    const precios = {
        basic:   { mensual: 299,  trimestral: 799,  anual: 2499 },
        premium: { mensual: 499,  trimestral: 1299, anual: 3999 },
        vip:     { mensual: 799,  trimestral: 1999, anual: 5999 },
    };

    const membresias = JSON.parse(document.getElementById('membresias-data').dataset.json);
    const clientesData = JSON.parse(document.getElementById('clientes-data').dataset.json);

    const clienteBusqueda = document.getElementById('cliente_busqueda');
    const clienteIdInput = document.getElementById('cliente_id');
    const membresiaSelect = document.getElementById('membresia_id');
    const sucursalSelect = document.getElementById('sucursal_id');
    const periodoSelect = document.getElementById('periodo');
    const montoInput = document.getElementById('monto');

    function cargarMembresias(clienteId) {
        membresiaSelect.innerHTML = '<option value="">Seleccione una membresía</option>';

        const lista = membresias[clienteId] || [];

        lista.forEach(m => {
            membresiaSelect.innerHTML += `
                <option value="${m.id}"
                    data-sucursal="${m.sucursal_id}"
                    data-tipo="${m.tipo.toLowerCase()}"
                    data-periodo="${m.periodo}">
                    ${m.tipo}
                </option>
            `;
        });

        sucursalSelect.value = '';
        periodoSelect.value = '';
        montoInput.value = '';
    }

    function buscarCliente() {
        const texto = this.value.trim();
        const clienteEncontrado = clientesData.find(c => c.label === texto);

        if (clienteEncontrado) {
            clienteIdInput.value = clienteEncontrado.id;
            cargarMembresias(clienteEncontrado.id);
        } else {
            clienteIdInput.value = '';
            membresiaSelect.innerHTML = '<option value="">Seleccione primero un cliente</option>';
            sucursalSelect.value = '';
            periodoSelect.value = '';
            montoInput.value = '';
        }
    }

    clienteBusqueda.addEventListener('input', buscarCliente);
    clienteBusqueda.addEventListener('change', buscarCliente);
    clienteBusqueda.addEventListener('blur', buscarCliente);

    membresiaSelect.addEventListener('change', function () {
        const opcion = this.options[this.selectedIndex];

        if (!opcion.value) {
            sucursalSelect.value = '';
            periodoSelect.value = '';
            montoInput.value = '';
            return;
        }

        const sucursal = opcion.dataset.sucursal;
        const tipo = opcion.dataset.tipo;
        const periodo = opcion.dataset.periodo;

        sucursalSelect.value = sucursal;
        periodoSelect.value = periodo;
        montoInput.value = precios[tipo]?.[periodo] ?? '';
    });
</script>
</x-layouts::app>