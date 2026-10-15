<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis préstamos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Libro</th>
                            <th class="py-2">Fecha préstamo</th>
                            <th class="py-2">Devolución estimada</th>
                            <th class="py-2">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($prestamos as $prestamo)
                            <tr class="border-b">
                                <td class="py-2">{{ $prestamo->libro->titulo }}</td>
                                <td class="py-2">{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                                <td class="py-2">{{ $prestamo->fecha_devolucion_estimada->format('d/m/Y') }}</td>
                                <td class="py-2">
                                    @if ($prestamo->estado === 'devuelto')
                                        <span class="text-green-700 font-medium">Devuelto</span>
                                    @else
                                        <span class="text-yellow-700 font-medium">Prestado</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-500">
                                    Todavía no has apartado ningún libro.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>