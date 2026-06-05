<x-layouts::app title="Historial de Pagos">
    <div class="container">
        <h1>Historial de Pagos</h1>

        @if(Session::has('mensaje'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row align-items-center mb-3">
            <div class="col-md-8">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Buscar por cliente, membresía, sucursal, método, concepto o registrado por..."
                    data-buscador-tabla="#tablaPagos"
                    data-sin-resultados="#sinResultadosPagos">
            </div>

            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <a href="{{ route('pago.create') }}" class="btn btn-success">
                    Registrar Pago
                </a>
            </div>
        </div>

        <table class="table table-bordered table-striped" id="tablaPagos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Membresía</th>
                    <th>Sucursal</th>
                    <th>Monto</th>
                    <th>Método</th>
                    <th>Concepto</th>
                    <th>Fecha</th>
                    <th>Registrado por</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pagos as $pago)
                    <tr>
                        <td>{{ $pago->id }}</td>

                        <td>
                            {{ $pago->cliente->user->name ?? 'N/A' }}
                        </td>

                        <td>
                            @if($pago->membresia)
                                <span class="badge bg-primary text-uppercase">
                                    {{ $pago->membresia->tipo }}
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    N/A
                                </span>
                            @endif
                        </td>

                        <td>
                            {{ $pago->sucursal->nombre ?? 'N/A' }}
                        </td>

                        <td>
                            ${{ number_format($pago->monto, 2) }}
                        </td>

                        <td>
                            {{ ucfirst($pago->metodo_pago) }}
                        </td>

                        <td>
                            {{ $pago->concepto ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $pago->fecha_pago ? \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y H:i') : 'N/A' }}
                        </td>

                        <td>
                            {{ $pago->registradoPor->name ?? 'N/A' }}
                        </td>

                        <td>
                            <form action="{{ route('pago.destroy', $pago->id) }}"
                                  method="POST"
                                  style="display:inline-block;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        onclick="return confirm('¿Eliminar pago?')"
                                        class="btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">
                            No hay pagos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div id="sinResultadosPagos" class="alert alert-warning d-none">
            No se encontraron pagos con ese criterio de búsqueda.
        </div>
    </div>

</x-layouts::app>