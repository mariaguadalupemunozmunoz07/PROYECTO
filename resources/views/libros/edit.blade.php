<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Libro') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('libros.update', $libro) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="titulo" :value="__('Título')" />
                        <x-text-input id="titulo" class="block mt-1 w-full" type="text" name="titulo"
                            :value="old('titulo', $libro->titulo)" required autofocus />
                        <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="autor" :value="__('Autor')" />
                        <x-text-input id="autor" class="block mt-1 w-full" type="text" name="autor"
                            :value="old('autor', $libro->autor)" required />
                        <x-input-error :messages="$errors->get('autor')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="isbn" :value="__('ISBN (opcional)')" />
                        <x-text-input id="isbn" class="block mt-1 w-full" type="text" name="isbn"
                            :value="old('isbn', $libro->isbn)" />
                        <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="categoria_id" :value="__('Categoría')" />
                        <select id="categoria_id" name="categoria_id" required
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">-- Selecciona una categoría --</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}" @selected(old('categoria_id', $libro->categoria_id) == $categoria->id)>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('categoria_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="cantidad_total" :value="__('Cantidad de ejemplares')" />
                        <x-text-input id="cantidad_total" class="block mt-1 w-full" type="number" min="1"
                            name="cantidad_total" :value="old('cantidad_total', $libro->cantidad_total)" required />
                        <x-input-error :messages="$errors->get('cantidad_total')" class="mt-2" />
                        <p class="text-sm text-gray-500 mt-1">
                            Actualmente disponibles: {{ $libro->cantidad_disponible }}
                        </p>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="descripcion" :value="__('Descripción (opcional)')" />
                        <textarea id="descripcion" name="descripcion" rows="4"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('descripcion', $libro->descripcion) }}</textarea>
                        <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('libros.index') }}" class="text-sm text-gray-600 underline mr-4">
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