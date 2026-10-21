<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Multas
        </h2>
    </x-slot>

    <style>
        .tabla-multas { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .tabla-multas th,
        .tabla-multas td { padding: 12px 8px; text-align: center; vertical-align: middle; border-bottom: 1px solid #f3e8ff; }
        .tabla-multas th { color: #6b21a8; font-weight: 600; background-color: #faf5ff; }
        .etiqueta { display: inline-block; padding: 4px 12px; border-radius: 9999px; font-size: 13px; font-weight: 600; }
        .etiqueta-verde { background-color: #dcfce7; color: #15803d; }
        .etiqueta-roja { background-color: #fee2e2; color: #b91c1c; }
        .boton-rosa { background-color: #fbcfe8; color: #9d174d; border-radius: 8px; font-weight: 600; padding: 6px 12px; border: none; cursor: pointer; }
        .boton-rosa:hover { background-color: #f9a8d4; }
        .resumen-multas { display: inline-block; background-color: #f3e8ff; color: #581c87; border: 1px solid #d8b4fe; border-radius: 8px; padding: 10px 16px; font-weight: 600; margin-bottom: 16px; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" style="overflow-x: auto;">

                <div class="resumen-multas">
                    Total pendiente por cobrar: ${{ number_format($totalPendiente, 0, ',', '.') }}
                </div>

                @if ($multas->isEmpty())
                    <p style="text-align: center; color: #6b7280;">Todavía no hay multas registradas.</p>
                @else
                    <table class="tabla-multas">
                        <colgroup>
                            <col style="width: 17%">
                            <col style="width: 23%">
                            <col style="width: 10%">
                            <col style="width: 13%">
                            <col style="width: 12%">
                            <col style="width: 12%">
                            <col style="width: 13%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Libro</th>
                                <th>Días de retraso</th>
                                <th>Valor</th>
                                <th>Estado</th>
                                <th>Fecha de pago</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($multas as $multa)
                                <tr>
                                    <td>{{ $multa->user->name }}</td>
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
                                    <td>
                                        @if ($multa->estado === 'pendiente')
                                            <form method="POST" action="{{ route('multas.pagar', $multa) }}"
                                                  onsubmit="return confirm('¿Marcar esta multa como pagada?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="boton-rosa">Marcar pagada</button>
                                            </form>
                                        @else
                                            —
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