<x-layouts::app title="Editar Rutina">
    <div class="container">
        <a href="{{ route('entrenador-panel.rutinas.index') }}" class="btn btn-secondary mb-3">
            Regresar
        </a>

        <form action="{{ route('entrenador-panel.rutinas.update', $rutina->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            @include('entrenador.rutinas.form', ['modo' => 'Editar'])
        </form>
    </div>
</x-layouts::app>