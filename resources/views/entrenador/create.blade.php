<x-layouts::app title="Agregar Entrenador">
    <div class="container">
        <a href="{{ route('entrenador.index') }}" class="btn btn-secondary mb-3">
            Regresar
        </a>

        <form action="{{ route('entrenador.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('entrenador.form', ['modo' => 'Agregar'])
        </form>
    </div>
</x-layouts::app>