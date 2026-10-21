<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis préstamos
        </h2>
    </x-slot>

    <style>
        .tabla-mis-prestamos { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .tabla-mis-prestamos th,
        .tabla-mis-prestamos td { padding: 12px 8px; text-align: center; vertical-align: middle; border-bottom: 1px solid #f3e8ff; }
        .tabla-mis-prestamos th { color: #6b21a8; font-weight: 600; background-color: #faf5ff; }
        .etiqueta { display: inline-block; padding: 4px 12px; border-radius: 9999px; font-size: 13px; font-weight: 600; }
        .etiqueta-verde { background-color: #dcfce7; color: #15803d; }
        .etiqueta-roja { background-color: #fee2e2; color: #b91c1c; }
        .etiqueta-gris { background-color: #f3f4f6; color: #4b5563; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($prestamos->isEmpty())
                    <p style="text-align:center; color:#6b7280;">Todavía no has apartado ningún libro.</p>
                @else
                    <table class="tabla-mis-prestamos">
                        <colgroup>
                            <col style="width: 30%">
                            <col style="width: 17%">
                            <col style="width: 19%">
                            <col style="width: 14%">
                            <col style="width: 20%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Libro</th>
                                <th>Fecha préstamo</th>
                                <th>Devolución estimada</th>
                                <th>Estado</th>
                                <th>Días restantes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prestamos as $prestamo)
                                <tr>
                                    <td>{{ $prestamo->libro->titulo }}</td>
                                    <td>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                                    <td>{{ $prestamo->fecha_devolucion_estimada->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="etiqueta etiqueta-gris">{{ ucfirst($prestamo->estado) }}</span>
                                    </td>
                                    <td>
                                        @if ($prestamo->estado === 'devuelto')
                                            —
                                        @else
                                            @php
                                                $dias = (int) now()->startOfDay()->diffInDays(
                                                    $prestamo->fecha_devolucion_estimada->copy()->startOfDay(),
                                                    false
                                                );
                                            @endphp

                                            @if ($dias < 0)
                                                <span class="etiqueta etiqueta-roja">Vencido hace {{ abs($dias) }} {{ abs($dias) === 1 ? 'día' : 'días' }}</span>
                                            @elseif ($dias === 0)
                                                <span class="etiqueta etiqueta-roja">Vence hoy</span>
                                            @elseif ($dias <= 2)
                                                <span class="etiqueta etiqueta-roja">Quedan {{ $dias }} {{ $dias === 1 ? 'día' : 'días' }}</span>
                                            @else
                                                <span class="etiqueta etiqueta-verde">Quedan {{ $dias }} días</span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>