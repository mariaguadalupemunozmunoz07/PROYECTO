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
                    style="display: inline-block; margin-bottom: 16px; padding: 10px 20px; background-color: #a855f7; color: white; font-weight: 600; border-radius: 8px; text-decoration: none;">
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
                                    <div style="display: flex; flex-direction: column; gap: 6px; width: 100px;">

                                        <a href="{{ route('libros.edit', $libro) }}"
                                            style="display: block; text-align: center; padding: 6px 12px; background-color: #fbcfe8; color: #9d174d; font-weight: 600; font-size: 14px; border-radius: 8px; text-decoration: none;">
                                            Editar
                                        </a>

                                        <form action="{{ route('libros.destroy', $libro) }}" method="POST"
                                            onsubmit="return confirm('¿Seguro que deseas eliminar este libro?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                style="width: 100%; padding: 6px 12px; background-color: #fbcfe8; color: #9d174d; font-weight: 600; font-size: 14px; border-radius: 8px; border: none; cursor: pointer;">
                                                Eliminar
                                            </button>
                                        </form>

                                    </div>
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