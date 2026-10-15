<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar fecha de devolución') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <p class="text-gray-700"><strong>Usuario:</strong> {{ $prestamo->user->name }}</p>
                <p class="text-gray-700"><strong>Libro:</strong> {{ $prestamo->libro->titulo }}</p>
                <p class="text-gray-700 mb-4"><strong>Fecha de préstamo:</strong> {{ $prestamo->fecha_prestamo->format('d/m/Y') }}</p>

                <form method="POST" action="{{ route('prestamos.update', $prestamo) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="fecha_devolucion_estimada" :value="__('Nueva fecha de devolución estimada')" />
                        <x-text-input id="fecha_devolucion_estimada" class="block mt-1 w-full" type="date"
                            name="fecha_devolucion_estimada"
                            :value="old('fecha_devolucion_estimada', $prestamo->fecha_devolucion_estimada->format('Y-m-d'))"
                            required autofocus />
                        <x-input-error :messages="$errors->get('fecha_devolucion_estimada')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('prestamos.index') }}" class="text-sm text-gray-600 underline mr-4">
                            Cancelar
                        </a>
                        <x-primary-button>
                            {{ __('Actualizar') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>