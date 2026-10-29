<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Multa;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrestamoController extends Controller
{
    /**
     * Display a listing of all loans (admin).
     */
    public function index()
    {
        $prestamos = Prestamo::with(['user', 'libro'])
            ->orderByDesc('fecha_prestamo')
            ->get();

        return view('prestamos.index', compact('prestamos'));
    }

    /**
     * Display the authenticated user's loans.
     */
    public function misPrestamos()
    {
        $prestamos = Prestamo::with('libro')
            ->where('user_id', Auth::id())
            ->orderByDesc('fecha_prestamo')
            ->get();

        return view('prestamos.mis-prestamos', compact('prestamos'));
    }

    /**
     * Reserve (apartar) a book for the authenticated user.
     */
    public function apartar(Libro $libro)
    {
        if ($libro->cantidad_disponible < 1) {
            return redirect()->route('catalogo')->with('error', 'Este libro no tiene ejemplares disponibles.');
        }

        Prestamo::create([
            'user_id' => Auth::id(),
            'libro_id' => $libro->id,
            'fecha_prestamo' => now(),
            'fecha_devolucion_estimada' => now()->addDays(15),
            'estado' => 'prestado',
        ]);

        $libro->decrement('cantidad_disponible');

        return redirect()->route('catalogo')->with('success', 'Has apartado el libro "'.$libro->titulo.'" correctamente.');
    }

    /**
     * Show the form to edit the estimated return date (admin).
     */
    public function edit(Prestamo $prestamo)
    {
        if ($prestamo->estado === 'devuelto') {
            return redirect()->route('prestamos.index')->with('success', 'Este préstamo ya fue devuelto, no se puede modificar.');
        }

        $prestamo->load(['user', 'libro']);

        return view('prestamos.edit', compact('prestamo'));
    }

    /**
     * Update the estimated return date (admin).
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        if ($prestamo->estado === 'devuelto') {
            return redirect()->route('prestamos.index')->with('success', 'Este préstamo ya fue devuelto, no se puede modificar.');
        }

        $request->validate([
            'fecha_devolucion_estimada' => [
                'required',
                'date',
                'after_or_equal:'.$prestamo->fecha_prestamo->format('Y-m-d'),
            ],
        ]);

        $prestamo->update([
            'fecha_devolucion_estimada' => $request->fecha_devolucion_estimada,
        ]);

        return redirect()->route('prestamos.index')->with('success', 'Fecha de devolución actualizada correctamente.');
    }

    /**
     * Mark a loan as returned (admin). Si se devuelve tarde, se genera o se actualiza la multa.
     */
    public function devolver(Prestamo $prestamo)
    {
        // Evita devolver dos veces el mismo préstamo (y sumar dos veces el ejemplar)
        if ($prestamo->estado === 'devuelto') {
            return redirect()->route('prestamos.index')->with('success', 'Este préstamo ya estaba devuelto.');
        }

        $hoy = now();

        $prestamo->update([
            'estado' => 'devuelto',
            'fecha_devolucion_real' => $hoy,
        ]);

        $prestamo->libro->increment('cantidad_disponible');

        // Días de retraso: positivo si hoy es después de la fecha estimada
        $diasRetraso = (int) $prestamo->fecha_devolucion_estimada
            ->copy()
            ->startOfDay()
            ->diffInDays($hoy->copy()->startOfDay(), false);

        if ($diasRetraso > 0) {
            $valor = $diasRetraso * Multa::VALOR_POR_DIA;

            // Puede que la multa ya exista (se creó mientras estaba vencido)
            $multa = Multa::firstOrNew(['prestamo_id' => $prestamo->id]);

            // Si ya estaba pagada no se cambia; si no, se deja con los días finales
            if (! $multa->exists || $multa->estado !== 'pagada') {
                $multa->user_id = $prestamo->user_id;
                $multa->dias_retraso = $diasRetraso;
                $multa->valor = $valor;

                if (! $multa->exists) {
                    $multa->estado = 'pendiente';
                }

                $multa->save();
            }

            return redirect()->route('prestamos.index')->with(
                'success',
                'Préstamo devuelto con '.$diasRetraso.' día(s) de retraso. La multa es de $'.number_format($multa->valor, 0, ',', '.').'.'
            );
        }

        return redirect()->route('prestamos.index')->with('success', 'Préstamo marcado como devuelto.');
    }
}