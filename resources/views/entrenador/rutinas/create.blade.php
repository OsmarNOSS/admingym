<x-layouts::app title="Crear Rutina">
    <div class="container">
        <a href="{{ route('entrenador-panel.rutinas.index') }}" class="btn btn-secondary mb-3">
            Regresar
        </a>

        <form action="{{ route('entrenador-panel.rutinas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('entrenador.rutinas.form', ['modo' => 'Crear'])
        </form>
    </div>
</x-layouts::app>