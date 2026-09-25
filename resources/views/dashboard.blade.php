<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-xl font-bold mb-2">
    ¡Bienvenido/a, {{ Auth::user()->name }}!
</h2>
<p>
    Has iniciado sesión como:
    <strong>{{ Auth::user()->role === 'admin' ? 'Administrador' : 'Usuario' }}</strong>
</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
