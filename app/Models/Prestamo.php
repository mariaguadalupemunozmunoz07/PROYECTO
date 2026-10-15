<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $fillable = [
        'user_id',
        'libro_id',
        'fecha_prestamo',
        'fecha_devolucion_estimada',
        'fecha_devolucion_real',
        'estado',
    ];

    protected $casts = [
        'fecha_prestamo' => 'date',
        'fecha_devolucion_estimada' => 'date',
        'fecha_devolucion_real' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }
}
