<x-layouts::app title="Agregar Sucursal">
<a href="{{route('sucursal.index')}}" class="btn btn-secondary">Regresar</a>

<form action="{{route('sucursal.update',  $sucursal->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    @include('sucursal.form', ['modo'=>'Editar'])
</form>
</x-layouts::app>
