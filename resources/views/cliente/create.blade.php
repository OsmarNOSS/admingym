<x-layouts::app title="Agregar Cliente">
    <a href="{{ route('cliente.index') }}" class="btn btn-secondary mb-3">
        Regresar
    </a>

    <form action="{{ route('cliente.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('cliente.form', ['modo' => 'Agregar'])
    </form>
</x-layouts::app>