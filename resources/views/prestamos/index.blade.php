<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Préstamos') }}
        </h2>
    </x-slot>

    <style>
        .tabla-prestamos {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }
        .tabla-prestamos th,
        .tabla-prestamos td {
            padding: 12px 8px;
            vertical-align: middle;
            border-bottom: 1px solid #e5e7eb;
        }
        .tabla-prestamos th {
            text-align: left;
            font-weight: 700;
        }
        .tabla-prestamos .centro {
            text-align: center;
        }
        .etiqueta {
            display: inline-block;
            padding: 4px 10px;
            font-weight: 600;
            font-size: 14px;
            border-radius: 8px;
            white-space: nowrap;
        }
        .etiqueta-verde {
            background-color: #dcfce7;
            color: #15803d;
        }
        .etiqueta-roja {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .acciones-prestamo {
            display: flex;
            flex-direction: column;
            gap: 6px;
            width: 140px;
            margin: 0 auto;
        }
        .boton-rosa {
            display: block;
            width: 100%;
            text-align: center;
            padding: 6px 12px;
            background-color: #fbcfe8;
            color: #9d174d;
            font-weight: 600;
            font-size: 14px;
            border-radius: 8px;
            border: none;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <table class="tabla-prestamos">
                    <colgroup>
                        <col style="width: 11%;">
                        <col style="width: 19%;">
                        <col style="width: 12%;">
                        <col style="width: 13%;">
                        <col style="width: 17%;">
                        <col style="width: 11%;">
                        <col style="width: 17%;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Libro</th>
                            <th class="centro">Fecha préstamo</th>
                            <th class="centro">Devolución estimada</th>
                            <th class="centro">Días restantes</th>
                            <th class="centro">Estado</th>
                            <th class="centro">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($prestamos as $prestamo)
                            @php
                                $dias = (int) now()->startOfDay()->diffInDays(
                                    $prestamo->fecha_devolucion_estimada->copy()->startOfDay(),
                                    false
                                );
                            @endphp
                            <tr>
                                <td>{{ $prestamo->user->name }}</td>
                                <td>{{ $prestamo->libro->titulo }}</td>
                                <td class="centro">{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                                <td class="centro">{{ $prestamo->fecha_devolucion_estimada->format('d/m/Y') }}</td>
                                <td class="centro">
                                    @if ($prestamo->estado === 'devuelto')
                                        <span class="text-gray-400">—</span>
                                    @elseif ($dias < 0)
                                        <span class="etiqueta etiqueta-roja">
                                            Vencido hace {{ abs($dias) }} {{ abs($dias) === 1 ? 'día' : 'días' }}
                                        </span>
                                    @elseif ($dias === 0)
                                        <span class="etiqueta etiqueta-roja">Vence hoy</span>
                                    @elseif ($dias <= 2)
                                        <span class="etiqueta etiqueta-roja">
                                            {{ $dias }} {{ $dias === 1 ? 'día' : 'días' }}
                                        </span>
                                    @else
                                        <span class="etiqueta etiqueta-verde">{{ $dias }} días</span>
                                    @endif
                                </td>
                                <td class="centro">
                                    @if ($prestamo->estado === 'devuelto')
                                        <span class="text-green-700 font-medium">Devuelto</span>
                                    @else
                                        <span class="text-yellow-700 font-medium">Prestado</span>
                                    @endif
                                </td>
                                <td class="centro">
                                    @if ($prestamo->estado !== 'devuelto')
                                        <div class="acciones-prestamo">

                                            <a href="{{ route('prestamos.edit', $prestamo) }}" class="boton-rosa">
                                                Editar fecha
                                            </a>

                                            <form action="{{ route('prestamos.devolver', $prestamo) }}" method="POST"
                                                onsubmit="return confirm('¿Marcar este préstamo como devuelto?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="boton-rosa">
                                                    Marcar devuelto
                                                </button>
                                            </form>

                                        </div>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="centro text-gray-500">
                                    No hay préstamos registrados todavía.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>