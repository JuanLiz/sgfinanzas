<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PUC extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pucs';
    protected $primaryKey = 'idpuc';

    public $timestamps = true;
    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = [
        'puc_codigo',
        'puc_descripcion',
        'puc_naturaleza',
        'estado',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'estado' => 'string',
        'puc_naturaleza' => 'string',
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
     * Obtiene las contrapartidas asociadas a esta cuenta PUC.
     */
    public function contrapartidas(): HasMany
    {
        return $this->hasMany(ContrapartidaPUC::class, 'puc_idpuc', 'idpuc');
    }
}
