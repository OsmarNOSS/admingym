<x-layouts::app title="Editar Membresía">
    <div class="container">
        <a href="{{ route('membresia.index') }}" class="btn btn-secondary mb-3">
            Regresar
        </a>

        <form action="{{ route('membresia.update', $membresia->id) }}" method="POST">
            @csrf
            @method('PATCH')

            @include('membresia.form', ['modo' => 'Editar'])
        </form>
    </div>
</x-layouts::app>