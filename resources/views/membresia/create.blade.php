<x-layouts::app title="Registrar Membresía">
    <div class="container">
        <a href="{{ route('membresia.index') }}" class="btn btn-secondary mb-3">
            Regresar
        </a>

        <form action="{{ route('membresia.store') }}" method="POST">
            @csrf

            @include('membresia.form', ['modo' => 'Registrar'])
        </form>
    </div>
</x-layouts::app>