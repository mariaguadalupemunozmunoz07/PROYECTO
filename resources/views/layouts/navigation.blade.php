@php
    $activo = 'border-bottom: 3px solid #7c3aed; color: #4c1d95; font-weight: 700;';
    $normal = 'border-bottom: 3px solid transparent; color: #6d28d9; font-weight: 500;';
    $base = 'display: inline-flex; align-items: center; padding: 4px 4px 0 4px; font-size: 14px; text-decoration: none;';
    $esAdmin = Auth::user()->role === 'admin';
@endphp

<style>
    .menu-usuario { background-color: #f3e8ff; border: 1px solid #d8b4fe; border-radius: 8px; overflow: hidden; }
    .menu-usuario-item {
        display: block; width: 100%; text-align: left; padding: 10px 18px;
        font-size: 14px; font-weight: 500; text-decoration: none;
        background: none; border: none; cursor: pointer;
    }
    .menu-usuario-perfil { color: #4c1d95; }
    .menu-usuario-perfil:hover { background-color: #e9d5ff; }
    .menu-usuario-salir { color: #9d174d; }
    .menu-usuario-salir:hover { background-color: #fbcfe8; }
    .menu-usuario-linea { height: 1px; background-color: #d8b4fe; margin: 0; border: none; }
</style>

<nav x-data="{ open: false }" style="background-color: #e9d5ff; border-bottom: 1px solid #d8b4fe;">
    <!-- Menú principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo style="width: 40px; height: 40px;" />
                    </a>
                </div>

                <!-- Enlaces -->
                <div class="hidden sm:flex" style="gap: 32px; margin-left: 40px;">
                    <a href="{{ route('dashboard') }}"
                       style="{{ $base }} {{ request()->routeIs('dashboard') ? $activo : $normal }}">Panel</a>

                    <a href="{{ route('catalogo') }}"
                       style="{{ $base }} {{ request()->routeIs('catalogo') ? $activo : $normal }}">Catálogo</a>

                    @if ($esAdmin)
                        <a href="{{ route('categorias.index') }}"
                           style="{{ $base }} {{ request()->routeIs('categorias.*') ? $activo : $normal }}">Categorías</a>

                        <a href="{{ route('libros.index') }}"
                           style="{{ $base }} {{ request()->routeIs('libros.*') ? $activo : $normal }}">Libros</a>

                        <a href="{{ route('prestamos.index') }}"
                           style="{{ $base }} {{ request()->routeIs('prestamos.index') || request()->routeIs('prestamos.edit') ? $activo : $normal }}">Préstamos</a>

                        <a href="{{ route('multas.index') }}"
                           style="{{ $base }} {{ request()->routeIs('multas.index') ? $activo : $normal }}">Multas</a>
                    @else
                        <a href="{{ route('prestamos.mis') }}"
                           style="{{ $base }} {{ request()->routeIs('prestamos.mis') ? $activo : $normal }}">Mis préstamos</a>

                        <a href="{{ route('multas.mis') }}"
                           style="{{ $base }} {{ request()->routeIs('multas.mis') ? $activo : $normal }}">Mis multas</a>
                    @endif
                </div>
            </div>

            <!-- Usuario -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button style="display: inline-flex; align-items: center; padding: 8px 12px; font-size: 14px; font-weight: 600; color: #4c1d95; background-color: #f3e8ff; border: 1px solid #d8b4fe; border-radius: 8px;">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="menu-usuario">
                            <a href="{{ route('profile.edit') }}" class="menu-usuario-item menu-usuario-perfil">Perfil</a>

                            <hr class="menu-usuario-linea">

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="menu-usuario-item menu-usuario-salir">Cerrar sesión</button>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Botón de menú (celular) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" style="padding: 8px; border-radius: 6px; color: #6d28d9;">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menú en celular -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div style="padding: 8px 0;">
            <a href="{{ route('dashboard') }}" style="display:block; padding: 8px 16px; color: #4c1d95; font-weight: {{ request()->routeIs('dashboard') ? '700' : '500' }};">Panel</a>
            <a href="{{ route('catalogo') }}" style="display:block; padding: 8px 16px; color: #4c1d95; font-weight: {{ request()->routeIs('catalogo') ? '700' : '500' }};">Catálogo</a>

            @if ($esAdmin)
                <a href="{{ route('categorias.index') }}" style="display:block; padding: 8px 16px; color: #4c1d95; font-weight: {{ request()->routeIs('categorias.*') ? '700' : '500' }};">Categorías</a>
                <a href="{{ route('libros.index') }}" style="display:block; padding: 8px 16px; color: #4c1d95; font-weight: {{ request()->routeIs('libros.*') ? '700' : '500' }};">Libros</a>
                <a href="{{ route('prestamos.index') }}" style="display:block; padding: 8px 16px; color: #4c1d95; font-weight: {{ request()->routeIs('prestamos.index') ? '700' : '500' }};">Préstamos</a>
                <a href="{{ route('multas.index') }}" style="display:block; padding: 8px 16px; color: #4c1d95; font-weight: {{ request()->routeIs('multas.index') ? '700' : '500' }};">Multas</a>
            @else
                <a href="{{ route('prestamos.mis') }}" style="display:block; padding: 8px 16px; color: #4c1d95; font-weight: {{ request()->routeIs('prestamos.mis') ? '700' : '500' }};">Mis préstamos</a>
                <a href="{{ route('multas.mis') }}" style="display:block; padding: 8px 16px; color: #4c1d95; font-weight: {{ request()->routeIs('multas.mis') ? '700' : '500' }};">Mis multas</a>
            @endif
        </div>

        <div style="padding: 8px 0; border-top: 1px solid #d8b4fe;">
            <div style="padding: 4px 16px;">
                <div style="font-weight: 600; color: #4c1d95;">{{ Auth::user()->name }}</div>
                <div style="font-size: 13px; color: #6d28d9;">{{ Auth::user()->email }}</div>
            </div>

            <a href="{{ route('profile.edit') }}" style="display:block; padding: 8px 16px; color: #4c1d95;">Perfil</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="display:block; width:100%; text-align:left; padding: 8px 16px; color: #9d174d; background:none; border:none;">Cerrar sesión</button>
            </form>
        </div>
    </div>
</nav>