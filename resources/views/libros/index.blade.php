<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Libros') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <a href="{{ route('libros.create') }}"
                    class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    + Nuevo Libro
                </a>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Título</th>
                            <th class="py-2">Autor</th>
                            <th class="py-2">Categoría</th>
                            <th class="py-2">Disponibles</th>
                            <th class="py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($libros as $libro)
                            <tr class="border-b">
                                <td class="py-2">{{ $libro->titulo }}</td>
                                <td class="py-2">{{ $libro->autor }}</td>
                                <td class="py-2">{{ $libro->categoria->nombre }}</td>
                                <td class="py-2">
                                    {{ $libro->cantidad_disponible }} / {{ $libro->cantidad_total }}
                                </td>
                                <td class="py-2">
                                    <a href="{{ route('libros.edit', $libro) }}"
                                        class="text-blue-600 hover:underline">Editar</a>

                                    <form action="{{ route('libros.destroy', $libro) }}" method="POST"
                                        class="inline"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar este libro?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline ml-2">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-500">
                                    No hay libros registrados todavía.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>