<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        .tabla-alertas { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .tabla-alertas th,
        .tabla-alertas td { padding: 10px 8px; text-align: center; vertical-align: middle; border-bottom: 1px solid #f3e8ff; }
        .tabla-alertas th { color: #6b21a8; font-weight: 600; background-color: #faf5ff; }
        .etiqueta { display: inline-block; padding: 4px 12px; border-radius: 9999px; font-size: 13px; font-weight: 600; }
        .etiqueta-roja { background-color: #fee2e2; color: #b91c1c; }
        .etiqueta-ambar { background-color: #fef3c7; color: #b45309; }
        .boton-rosa { display: inline-block; background-color: #fbcfe8; color: #9d174d; border-radius: 8px; font-weight: 600; padding: 6px 14px; text-decoration: none; }
        .boton-rosa:hover { background-color: #f9a8d4; }
        .tarjetas-resumen { display: flex; flex-wrap: wrap; gap: 16px; }
        .tarjeta-resumen { flex: 1 1 200px; border-radius: 12px; padding: 16px 20px; background-color: #ffffff; box-shadow: 0 1px 2px rgba(0,0,0,.08); }
        .tarjeta-resumen .numero { font-size: 32px; font-weight: 700; line-height: 1.1; }
        .tarjeta-resumen .texto { font-size: 14px; color: #6b7280; margin-top: 4px; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="display: flex; flex-direction: column; gap: 24px;">

            <!-- Bienvenida -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900">¡Bienvenido/a, {{ Auth::user()->name }}!</h3>
                <p class="text-gray-900" style="margin-top: 4px;">
                    Has iniciado sesión como:
                    <strong>{{ Auth::user()->role === 'admin' ? 'Administrador' : 'Usuario' }}</strong>
                </p>
            </div>

            @if (Auth::user()->role === 'admin')

                <!-- Resumen de inventario -->
                <div class="tarjetas-resumen">
                    <div class="tarjeta-resumen">
                        <div class="numero" style="color: #6d28d9;">{{ $totalLibros }}</div>
                        <div class="texto">Libros registrados</div>
                    </div>
                    <div class="tarjeta-resumen">
                        <div class="numero" style="color: #b91c1c;">{{ $agotados->count() }}</div>
                        <div class="texto">Libros agotados</div>
                    </div>
                    <div class="tarjeta-resumen">
                        <div class="numero" style="color: #b45309;">{{ $porAgotarse->count() }}</div>
                        <div class="texto">Libros por agotarse</div>
                    </div>
                </div>

                <!-- Agotados -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" style="overflow-x: auto;">
                    <h3 class="text-lg font-semibold" style="color: #b91c1c; margin-bottom: 12px;">Libros agotados</h3>

                    @if ($agotados->isEmpty())
                        <p style="color: #6b7280;">No hay libros agotados. ¡Todo bien!</p>
                    @else
                        <table class="tabla-alertas">
                            <colgroup>
                                <col style="width: 34%">
                                <col style="width: 24%">
                                <col style="width: 14%">
                                <col style="width: 14%">
                                <col style="width: 14%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>Libro</th>
                                    <th>Categoría</th>
                                    <th>Disponibles</th>
                                    <th>Total</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agotados as $libro)
                                    <tr>
                                        <td>{{ $libro->titulo }}</td>
                                        <td>{{ $libro->categoria->nombre ?? '—' }}</td>
                                        <td><span class="etiqueta etiqueta-roja">0</span></td>
                                        <td>{{ $libro->cantidad_total }}</td>
                                        <td><a href="{{ route('libros.edit', $libro) }}" class="boton-rosa">Editar</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <!-- Por agotarse -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" style="overflow-x: auto;">
                    <h3 class="text-lg font-semibold" style="color: #b45309; margin-bottom: 4px;">Libros por agotarse</h3>
                    <p style="color: #6b7280; font-size: 14px; margin-bottom: 12px;">
                        Libros que tienen entre 1 y {{ $umbral }} ejemplares disponibles.
                    </p>

                    @if ($porAgotarse->isEmpty())
                        <p style="color: #6b7280;">Ningún libro está por agotarse.</p>
                    @else
                        <table class="tabla-alertas">
                            <colgroup>
                                <col style="width: 34%">
                                <col style="width: 24%">
                                <col style="width: 14%">
                                <col style="width: 14%">
                                <col style="width: 14%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>Libro</th>
                                    <th>Categoría</th>
                                    <th>Disponibles</th>
                                    <th>Total</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($porAgotarse as $libro)
                                    <tr>
                                        <td>{{ $libro->titulo }}</td>
                                        <td>{{ $libro->categoria->nombre ?? '—' }}</td>
                                        <td><span class="etiqueta etiqueta-ambar">{{ $libro->cantidad_disponible }}</span></td>
                                        <td>{{ $libro->cantidad_total }}</td>
                                        <td><a href="{{ route('libros.edit', $libro) }}" class="boton-rosa">Editar</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

            @endif

        </div>
    </div>
</x-app-layout>