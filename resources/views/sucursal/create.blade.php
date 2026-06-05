<x-layouts::app title="Agregar Sucursal">
<a href="{{route('sucursal.index')}}">Regresar</a>

<form action="{{route('sucursal.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('sucursal.form',['modo'=>'Agregar'])
</form>
</x-layouts::app>
