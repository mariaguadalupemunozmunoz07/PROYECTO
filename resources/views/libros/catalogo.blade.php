<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catálogo de Libros') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            @forelse ($categorias as $categoria)
                @if ($categoria->libros->count() > 0)
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-3">{{ $categoria->nombre }}</h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($categoria->libros as $libro)
                                <div class="bg-white shadow-sm rounded-lg p-4 flex flex-col justify-between">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $libro->titulo }}</h4>
                                        <p class="text-sm text-gray-600">{{ $libro->autor }}</p>

                                        @if ($libro->descripcion)
                                            <div x-data="{ abierto: false, cortado: false }"
                                                 x-init="$nextTick(() => { cortado = $refs.texto.scrollHeight > $refs.texto.clientHeight + 1 })"
                                                 @resize.window="if (! abierto) { cortado = $refs.texto.scrollHeight > $refs.texto.clientHeight + 1 }"
                                                 class="mt-2">
                                                <p x-ref="texto"
                                                   class="text-sm text-gray-500"
                                                   style="white-space: pre-line;"
                                                   :style="abierto ? '' : 'display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;'">{{ $libro->descripcion }}</p>

                                                <button type="button"
                                                        x-show="cortado || abierto"
                                                        @click="abierto = ! abierto"
                                                        x-text="abierto ? 'Ver menos' : 'Ver más'"
                                                        style="margin-top: 4px; color: #be185d; font-size: 13px; font-weight: 600; background: none; border: none; cursor: pointer;">
                                                </button>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-4 flex items-center justify-between">
                                        @if ($libro->cantidad_disponible > 0)
                                            <span class="text-sm font-medium text-green-700">
                                                Disponible ({{ $libro->cantidad_disponible }})
                                            </span>
                                        @else
                                            <span class="text-sm font-medium text-red-700">
                                                No disponible
                                            </span>
                                        @endif
                                    </div>

                                    @if (Auth::user()->role !== 'admin')
                                        <form action="{{ route('prestamos.apartar', $libro) }}" method="POST" class="mt-3">
                                            @csrf
                                            <button type="submit"
                                                @if ($libro->cantidad_disponible < 1) disabled @endif
                                                style="width: 100%; padding: 8px 16px; background-color: {{ $libro->cantidad_disponible > 0 ? '#a855f7' : '#d1d5db' }}; color: white; font-weight: 600; border-radius: 8px; border: none; cursor: {{ $libro->cantidad_disponible > 0 ? 'pointer' : 'not-allowed' }};">
                                                Apartar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @empty
                <p class="text-gray-500">No hay categorías ni libros registrados todavía.</p>
            @endforelse

        </div>
    </div>
</x-app-layout>