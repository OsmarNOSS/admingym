<x-layouts::app title="Editar Entrenador">
    <a href="{{ route('entrenador.index') }}" class="btn btn-secondary mb-3">
        Regresar
    </a>

    <form action="{{ route('entrenador.update', $entrenador->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        @include('entrenador.form', ['modo' => 'Editar'])
    </form>
</x-layouts::app>