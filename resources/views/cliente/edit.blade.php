<x-layouts::app title="Editar Cliente">
    <a href="{{ route('cliente.index') }}" class="btn btn-secondary mb-3">
        Regresar
    </a>

    <form action="{{ route('cliente.update', $cliente->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        @include('cliente.form', ['modo' => 'Editar'])
    </form>
</x-layouts::app>