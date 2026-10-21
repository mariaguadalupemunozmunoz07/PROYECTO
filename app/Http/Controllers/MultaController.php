<?php

namespace App\Http\Controllers;

use App\Models\Multa;
use Illuminate\Support\Facades\Auth;

class MultaController extends Controller
{
    /**
     * Lista de todas las multas (administrador).
     */
    public function index()
    {
        $multas = Multa::with(['user', 'prestamo.libro'])
            ->orderByRaw("estado = 'pagada'")
            ->orderByDesc('created_at')
            ->get();

        $totalPendiente = Multa::where('estado', 'pendiente')->sum('valor');

        return view('multas.index', compact('multas', 'totalPendiente'));
    }

    /**
     * Marcar una multa como pagada (administrador).
     */
    public function pagar(Multa $multa)
    {
        if ($multa->estado === 'pagada') {
            return redirect()->route('multas.index')->with('success', 'Esta multa ya estaba pagada.');
        }

        $multa->update([
            'estado' => 'pagada',
            'fecha_pago' => now(),
        ]);

        return redirect()->route('multas.index')->with('success', 'Multa marcada como pagada.');
    }

    /**
     * Multas del usuario que inició sesión.
     */
    public function misMultas()
    {
        $multas = Multa::with('prestamo.libro')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        $totalPendiente = $multas->where('estado', 'pendiente')->sum('valor');

        return view('multas.mis-multas', compact('multas', 'totalPendiente'));
    }
}
