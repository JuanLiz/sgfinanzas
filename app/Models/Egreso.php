<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Egreso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'egresos';
    protected $primaryKey = 'idegr';

    public $timestamps = true;
    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = [
        'egres_monto',
        'egres_fecha',
        'egres_descripcion',
        'egres_tipo',
        'usu_idusu',
        'contpuc_idcontpuc',
        'estado',
    ];

    protected $casts = [
        'egres_monto' => 'decimal:2',
        'egres_fecha' => 'date',
        'fecha_registro' => 'datetime',
        'estado' => 'string',
        'egres_tipo' => 'string',
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
     * Obtiene el usuario al que pertenece este egreso.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usu_idusu', 'idusu');
    }

    /**
     * Obtiene la contrapartida contable asociada a este egreso.
     */
    public function contrapartida(): BelongsTo
    {
        return $this->belongsTo(ContrapartidaPUC::class, 'contpuc_idcontpuc', 'idcontpuc');
    }
}
