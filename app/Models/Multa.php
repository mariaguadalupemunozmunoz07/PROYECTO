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
}