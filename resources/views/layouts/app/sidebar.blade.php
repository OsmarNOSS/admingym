<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.header>
            <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.group :heading="__('Platform')" class="grid">

                {{-- Dashboard general: no se muestra a cliente ni entrenador --}}
@if(!auth()->user()->hasAnyRole(['cliente', 'entrenador']))
    <flux:sidebar.item
        icon="home"
        :href="route('dashboard')"
        :current="request()->routeIs('dashboard')"
        wire:navigate>
        Dashboard
    </flux:sidebar.item>
@endif

{{-- Menú exclusivo del Super Admin --}}
@role('super_admin')
    <flux:sidebar.item
        icon="building-office"
        :href="route('sucursal.index')"
        :current="request()->routeIs('sucursal.*')"
        wire:navigate>
        Sucursales
    </flux:sidebar.item>

    <flux:sidebar.item
        icon="user"
        :href="route('cliente.index')"
        :current="request()->routeIs('cliente.*')"
        wire:navigate>
        Clientes
    </flux:sidebar.item>

    <flux:sidebar.item
        icon="shield-check"
        :href="route('entrenador.index')"
        :current="request()->routeIs('entrenador.*')"
        wire:navigate>
        Entrenadores
    </flux:sidebar.item>

    <flux:sidebar.item
        icon="users"
        :href="route('membresia.index')"
        :current="request()->routeIs('membresia.*')"
        wire:navigate>
        Membresías
    </flux:sidebar.item>

    <flux:sidebar.item
        icon="users"
        :href="route('pago.index')"
        :current="request()->routeIs('pago.*')"
        wire:navigate>
        Pagos
    </flux:sidebar.item>

    <flux:sidebar.item
        icon="users"
        :href="route('usuario.index')"
        :current="request()->routeIs('usuario.*')"
        wire:navigate>
        Usuarios
    </flux:sidebar.item>
@endrole

@role('admin_sucursal')

    <flux:sidebar.item
        icon="user"
        :href="route('cliente.index')"
        :current="request()->routeIs('cliente.*')"
        wire:navigate>
        Clientes
    </flux:sidebar.item>

    <flux:sidebar.item
        icon="shield-check"
        :href="route('entrenador.index')"
        :current="request()->routeIs('entrenador.*')"
        wire:navigate>
        Entrenadores
    </flux:sidebar.item>

    <flux:sidebar.item
        icon="users"
        :href="route('membresia.index')"
        :current="request()->routeIs('membresia.*')"
        wire:navigate>
        Membresías
    </flux:sidebar.item>

    <flux:sidebar.item
        icon="users"
        :href="route('pago.index')"
        :current="request()->routeIs('pago.*')"
        wire:navigate>
        Pagos
    </flux:sidebar.item>
@endrole

{{-- Menú exclusivo de Recepcionista --}}
@role('recepcionista')
    <flux:sidebar.item
        icon="user"
        :href="route('recepcion.clientes.index')"
        :current="request()->routeIs('recepcion.clientes.*')"
        wire:navigate>
        Clientes
    </flux:sidebar.item>

    <flux:sidebar.item
        icon="user"
        :href="route('asistencias.index')"
        :current="request()->routeIs('asistencias.*')"
        wire:navigate>
        Asistencias
    </flux:sidebar.item>

    <flux:sidebar.item
        icon="users"
        :href="route('recepcion.membresias.index')"
        :current="request()->routeIs('recepcion.membresias.*')"
        wire:navigate>
        Membresías
    </flux:sidebar.item>
    <flux:sidebar.item
        icon="users"
        :href="route('pago.index')"
        :current="request()->routeIs('pago.*')"
        wire:navigate>
        Pagos
    </flux:sidebar.item>
@endrole

{{-- Menú exclusivo de Cliente --}}
@role('cliente')
    <flux:sidebar.item
        icon="user"
        :href="route('cliente-panel.perfil')"
        :current="request()->routeIs('cliente-panel.perfil')"
        wire:navigate>
        Mi Perfil
    </flux:sidebar.item>

    <flux:sidebar.item
        icon="users"
        :href="route('cliente-panel.membresia')"
        :current="request()->routeIs('cliente-panel.membresia')"
        wire:navigate>
        Mi Membresía
    </flux:sidebar.item>

    <flux:sidebar.item
        icon="user"
        :href="route('cliente-panel.entrenador')"
        :current="request()->routeIs('cliente-panel.entrenador')"
        wire:navigate>
        Mi Entrenador
    </flux:sidebar.item>

    <flux:sidebar.item
        icon="users"
        :href="route('cliente-panel.rutinas')"
        :current="request()->routeIs('cliente-panel.rutinas')"
        wire:navigate>
        Mis Rutinas
    </flux:sidebar.item>
@endrole

{{-- Menú exclusivo de Entrenador --}}
@role('entrenador')
    <flux:sidebar.item
        icon="user"
        :href="route('entrenador-panel.perfil')"
        :current="request()->routeIs('entrenador-panel.perfil')"
        wire:navigate>
        Mi Perfil
    </flux:sidebar.item>
    <flux:sidebar.item
        icon="users"
        :href="route('entrenador-panel.mis-clientes')"
        :current="request()->routeIs('entrenador-panel.mis-clientes')"
        wire:navigate>
        Mis Clientes
    </flux:sidebar.item>

    <flux:sidebar.item
        icon="user"
        :href="route('entrenador-panel.elegir-clientes')"
        :current="request()->routeIs('entrenador-panel.elegir-clientes')"
        wire:navigate>
        Elegir Clientes
    </flux:sidebar.item>

    <flux:sidebar.item
        icon="users"
        :href="route('entrenador-panel.rutinas.index')"
        :current="request()->routeIs('entrenador-panel.rutinas.*')"
        wire:navigate>
        Rutinas
    </flux:sidebar.item>
@endrole

            </flux:sidebar.group>
        </flux:sidebar.nav>

        <flux:spacer />

        <x-desktop-user-menu class="hidden lg:block" />
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile
                :initials="auth()->user()->initials()"
                icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <flux:avatar
                                :name="auth()->user()->name"
                                :initials="auth()->user()->initials()" />

                            <div class="grid flex-1 text-start text-left leading-tight">
                                <flux:heading class="truncate !text-zinc-900 dark:!text-white">
                                    {{ auth()->user()->name }}
                                </flux:heading>
                                <flux:text class="truncate !text-zinc-500 dark:!text-zinc-300">
                                    {{ auth()->user()->email }}
                                </flux:text>
                            </div>
                        </div>
                    </div>
                </flux:menu>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate class="!text-zinc-900 dark:!text-white">
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item
                        as="button"
                        type="submit"
                        icon="arrow-right-start-on-rectangle"
                        class="w-full cursor-pointer !text-zinc-900 dark:!text-white">
                        {{ __('Log out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @persist('toast')
    <flux:toast.group>
        <flux:toast />
    </flux:toast.group>
    @endpersist

    @fluxScripts

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('input', function (event) {
        const input = event.target;

        if (!input.matches('[data-buscador-tabla]')) {
            return;
        }

        const tablaSelector = input.dataset.buscadorTabla;
        const sinResultadosSelector = input.dataset.sinResultados;

        const tabla = document.querySelector(tablaSelector);
        const sinResultados = document.querySelector(sinResultadosSelector);

        if (!tabla || !sinResultados) {
            return;
        }

        const texto = input.value.toLowerCase().trim();
        const filas = tabla.querySelectorAll('tbody tr');

        let visibles = 0;

        filas.forEach(function (fila) {
            const coincide = fila.textContent.toLowerCase().includes(texto);

            fila.style.display = coincide ? '' : 'none';

            if (coincide) {
                visibles++;
            }
        });

        sinResultados.classList.toggle('d-none', visibles > 0);
    });
</script>
</body>

</html>