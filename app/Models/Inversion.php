<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inversion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inversiones';
    protected $primaryKey = 'idinversion';

    public $timestamps = true;
    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = [
        'inversion_monto',
        'inversion_fecha',
        'inversion_descripcion',
        'inversion_tipo',
        'inversion_rendimiento_esperado',
        'contpuc_idcontpuc',
        'usu_idusu',
        'estado',
    ];

    protected $casts = [
        'inversion_monto' => 'decimal:2',
        'inversion_fecha' => 'date',
        'inversion_rendimiento_esperado' => 'decimal:2',
        'fecha_registro' => 'datetime',
        'estado' => 'string',
        'inversion_tipo' => 'string',
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
     * Obtiene el usuario al que pertenece esta inversión.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usu_idusu', 'idusu');
    }

    /**
     * Obtiene la contrapartida contable asociada a esta inversión.
     */
    public function contrapartida(): BelongsTo
    {
        return $this->belongsTo(ContrapartidaPUC::class, 'contpuc_idcontpuc', 'idcontpuc');
    }
}
