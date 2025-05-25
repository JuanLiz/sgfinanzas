<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostoFijo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'costos_fijos';
    protected $primaryKey = 'idcostofijo';

    public $timestamps = true;
    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = [
        'costofijo_monto',
        'costofijo_descripcion',
        'costofijo_frecuencia',
        'costofijo_dia_mes',
        'costofijo_proximo_pago',
        'contpuc_idcontpuc',
        'usu_idusu',
        'estado',
    ];

    protected $casts = [
        'costofijo_monto' => 'decimal:2',
        'costofijo_dia_mes' => 'integer',
        'costofijo_proximo_pago' => 'date',
        'fecha_registro' => 'datetime',
        'estado' => 'string',
        'costofijo_frecuencia' => 'string',
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
     * Obtiene el usuario al que pertenece este costo fijo.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usu_idusu', 'idusu');
    }

    /**
     * Obtiene la contrapartida contable asociada a este costo fijo.
     */
    public function contrapartida(): BelongsTo
    {
        return $this->belongsTo(ContrapartidaPUC::class, 'contpuc_idcontpuc', 'idcontpuc');
    }
}
