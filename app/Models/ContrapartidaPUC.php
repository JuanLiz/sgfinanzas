<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContrapartidaPUC extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contrapartida_puc';
    protected $primaryKey = 'idcontpuc';

    public $timestamps = true;
    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = [
        'contpuc_codigo',
        'contpuc_descripcion',
        'contpuc_tipo',
        'puc_idpuc',
        'estado',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'estado' => 'string',
        'contpuc_tipo' => 'string',
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
     * Obtiene la cuenta PUC a la que está asociada esta contrapartida.
     */
    public function puc(): BelongsTo
    {
        return $this->belongsTo(PUC::class, 'puc_idpuc', 'idpuc');
    }

    /**
     * Obtiene los ingresos asociados a esta contrapartida.
     */
    public function ingresos(): HasMany
    {
        return $this->hasMany(Ingreso::class, 'contpuc_idcontpuc', 'idcontpuc');
    }

    /**
     * Obtiene los egresos asociados a esta contrapartida.
     */
    public function egresos(): HasMany
    {
        return $this->hasMany(Egreso::class, 'contpuc_idcontpuc', 'idcontpuc');
    }
}
