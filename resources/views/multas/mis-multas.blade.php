<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis multas
        </h2>
    </x-slot>

    <style>
        .tabla-mis-multas { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .tabla-mis-multas th,
        .tabla-mis-multas td { padding: 12px 8px; text-align: center; vertical-align: middle; border-bottom: 1px solid #f3e8ff; }
        .tabla-mis-multas th { color: #6b21a8; font-weight: 600; background-color: #faf5ff; }
        .etiqueta { display: inline-block; padding: 4px 12px; border-radius: 9999px; font-size: 13px; font-weight: 600; }
        .etiqueta-verde { background-color: #dcfce7; color: #15803d; }
        .etiqueta-roja { background-color: #fee2e2; color: #b91c1c; }
        .resumen-multas { display: inline-block; background-color: #f3e8ff; color: #581c87; border: 1px solid #d8b4fe; border-radius: 8px; padding: 10px 16px; font-weight: 600; margin-bottom: 16px; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" style="overflow-x: auto;">

                @if ($multas->isEmpty())
                    <p style="text-align: center; color: #6b7280;">
                        No tienes multas. ¡Gracias por devolver tus libros a tiempo!
                    </p>
                @else
                    <div class="resumen-multas">
                        Total pendiente por pagar: ${{ number_format($totalPendiente, 0, ',', '.') }}
                    </div>

                    <table class="tabla-mis-multas">
                        <colgroup>
                            <col style="width: 32%">
                            <col style="width: 14%">
                            <col style="width: 18%">
                            <col style="width: 18%">
                            <col style="width: 18%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Libro</th>
                                <th>Días de retraso</th>
                                <th>Valor</th>
                                <th>Estado</th>
                                <th>Fecha de pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($multas as $multa)
                                <tr>
                                    <td>{{ $multa->prestamo->libro->titulo }}</td>
                                    <td>{{ $multa->dias_retraso }}</td>
                                    <td>${{ number_format($multa->valor, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($multa->estado === 'pagada')
                                            <span class="etiqueta etiqueta-verde">Pagada</span>
                                        @else
                                            <span class="etiqueta etiqueta-roja">Pendiente</span>
                                        @endif
                                    </td>
                                    <td>{{ $multa->fecha_pago ? $multa->fecha_pago->format('d/m/Y') : '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <p style="margin-top: 16px; font-size: 14px; color: #6b7280;">
                        Para pagar una multa, acércate a la biblioteca. El administrador la marcará como pagada.
                    </p>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>