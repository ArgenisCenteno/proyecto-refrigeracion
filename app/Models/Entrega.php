<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id',
        'empleado_id',
        'fecha_entrega',
        'estado',
        'observaciones',
        'fecha_entrega'
    ];

    /**
     * Relación con el modelo Venta.
     */
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    /**
     * Relación con el modelo Empleado.
     */
    public function empleado()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'fecha_entrega' => 'date',
    ];
    
}
