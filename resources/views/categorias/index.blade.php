<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categorías') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <a href="{{ route('categorias.create') }}"
                    class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    + Nueva Categoría
                </a>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Nombre</th>
                            <th class="py-2">Descripción</th>
                            <th class="py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categorias as $categoria)
                            <tr class="border-b">
                                <td class="py-2">{{ $categoria->nombre }}</td>
                                <td class="py-2">{{ $categoria->descripcion }}</td>
                                <td class="py-2">
                                    <a href="{{ route('categorias.edit', $categoria) }}"
                                        class="text-blue-600 hover:underline">Editar</a>

                                    <form action="{{ route('categorias.destroy', $categoria) }}" method="POST"
                                        class="inline"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar esta categoría?');">
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
                                <td colspan="3" class="py-4 text-center text-gray-500">
                                    No hay categorías registradas todavía.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>