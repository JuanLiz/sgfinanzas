<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetaAhorro extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'metas_ahorro';
    protected $primaryKey = 'idmetah';

    public $timestamps = true;
    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = [
        'metah_monto',
        'metah_descripcion',
        'metah_fecha_meta',
        'metah_periodo',  // Campo nuevo para la frecuencia
        'metah_monto_actual', // Campo para rastrear el progreso actual
        'usu_idusu',
        'estado',
    ];

    protected $casts = [
        'metah_monto' => 'decimal:2',
        'metah_monto_actual' => 'decimal:2',
        'metah_fecha_meta' => 'date',
        'fecha_registro' => 'datetime',
        'estado' => 'string',
    ];

    /**
     * Los atributos con valores por defecto.
     *
     * @var array
     */
    protected $attributes = [
        'estado' => 'Activo',
        'metah_monto_actual' => 0.00,
    ];

    /**
     * Obtiene el usuario al que pertenece esta meta de ahorro.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usu_idusu', 'idusu');
    }
    
    /**
     * Calcula el porcentaje de progreso hacia la meta
     * 
     * @return float
     */
    public function getPorcentajeProgresoAttribute(): float
    {
        if ($this->metah_monto <= 0) {
            return 0;
        }
        
        return min(100, ($this->metah_monto_actual / $this->metah_monto) * 100);
    }
}
