<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingreso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ingresos';
    protected $primaryKey = 'iding';

    public $timestamps = true;
    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = [
        'ingre_monto',
        'ingre_fecha',
        'ingre_descripcion',
        'usu_idusu',
        'contpuc_idcontpuc',
        'estado',
    ];

    protected $casts = [
        'ingre_monto' => 'decimal:2',
        'ingre_fecha' => 'date',
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
    ];

    /**
     * Obtiene el usuario al que pertenece este ingreso.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usu_idusu', 'idusu');
    }

    /**
     * Obtiene la contrapartida contable asociada a este ingreso.
     */
    public function contrapartida(): BelongsTo
    {
        return $this->belongsTo(ContrapartidaPUC::class, 'contpuc_idcontpuc', 'idcontpuc');
    }
}
