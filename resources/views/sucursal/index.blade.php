<x-layouts::app title="Sucursales">
    
    <div class="container">
        <h1>Sucursales</h1>
        @if(Session::has('mensaje'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('mensaje') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
        @endif

        <input type="text" id="buscador" class="form-control mb-3" placeholder="Buscar por cliente, sucursal, tipo...">
<!---->
        <a href="{{route('sucursal.create')}}" class="btn btn-success">Registrar una Sucursal</a>
        
        <br>
        <br>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Capacidad</th>
                    <th>Hora apertura</th>
                    <th>Hora cierre</th>
                    <th>Activa</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($sucursales as $sucursal)
                <tr>
                    <td>
                        @if($sucursal->foto_portada)
                        <img src="{{ asset('storage/'.$sucursal->foto_portada) }}"
                            width="80"
                            alt="Portada">
                        @else
                        Sin foto
                        @endif
                    </td>
                    <td>{{ $sucursal->id }}</td>
                    <td>{{ $sucursal->nombre }}</td>
                    <td>{{ $sucursal->direccion }}</td>
                    <td>{{ $sucursal->telefono }}</td>
                    <td>{{ $sucursal->capacidad }}</td>
                    <td>{{ $sucursal->hora_apertura }}</td>
                    <td>{{ $sucursal->hora_cierre }}</td>
                    <td>
                        @if($sucursal->activa)
                        Sí
                        @else
                        No
                        @endif
                    </td>
                    <td>
                        <a href="{{route('sucursal.edit', $sucursal->id)}}"
                            class="btn btn-warning btn-sm">
                            Editar
                        </a>

                        <form action="{{route('sucursal.destroy', $sucursal->id)}}" method="POST" style="display:inline;">
                            @csrf
                            {{method_field('DELETE')}}

                            <button type="submit" onclick="return confirm('¿Quieres borrar la informacion?')" class="btn btn-danger btn-sm">
                                Eliminar
                            </button>
                        </form>

                        <a href="{{route('sucursal.show', $sucursal->id)}}"
                            class="btn btn-info btn-sm">
                            Detalles
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
document.getElementById('buscador').addEventListener('keyup', function() {
    const texto = this.value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(fila => {
        fila.style.display = fila.textContent.toLowerCase().includes(texto) ? '' : 'none';
    });
});
</script>
</x-layouts::app>