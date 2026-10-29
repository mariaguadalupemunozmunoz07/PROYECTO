<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Multa extends Model
{
    // Valor que se cobra por cada día de retraso (en pesos)
    public const VALOR_POR_DIA = 1000;

    protected $fillable = [
        'prestamo_id',
        'user_id',
        'dias_retraso',
        'valor',
        'estado',
        'fecha_pago',
    ];

    protected $casts = [
        'fecha_pago' => 'date',
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Revisa los préstamos vencidos que aún no se devuelven y
     * crea o actualiza su multa con los días de retraso de hoy.
     * Si se manda un $userId, solo revisa los préstamos de ese usuario.
     */
    public static function sincronizar(?int $userId = null): void
    {
        $hoy = now()->startOfDay();

        $vencidos = Prestamo::where('estado', '!=', 'devuelto')
            ->whereDate('fecha_devolucion_estimada', '<', $hoy->toDateString())
            ->when($userId, fn ($q) => $q->where('user_id', $userId))
            ->get();

        foreach ($vencidos as $prestamo) {
            $dias = (int) $prestamo->fecha_devolucion_estimada
                ->copy()
                ->startOfDay()
                ->diffInDays($hoy, false);

            if ($dias <= 0) {
                continue;
            }

            $multa = self::firstOrNew(['prestamo_id' => $prestamo->id]);

            // Si ya está pagada, no se toca
            if ($multa->exists && $multa->estado === 'pagada') {
                continue;
            }

            $multa->user_id = $prestamo->user_id;
            $multa->dias_retraso = $dias;
            $multa->valor = $dias * self::VALOR_POR_DIA;

            if (! $multa->exists) {
                $multa->estado = 'pendiente';
            }

            $multa->save();
        }
    }
}