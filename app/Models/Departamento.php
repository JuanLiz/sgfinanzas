<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'departamentos';
    protected $primaryKey = 'iddepar';

    public $timestamps = true;
    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = [
        'depar_nombre',
        'estado',
    ];

    protected $casts = [
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

    public function municipios(): HasMany
    {
        return $this->hasMany(Municipio::class, 'depar_iddepar', 'iddepar');
    }
    
    public function users(): HasMany
    {
        return $this->hasManyThrough(
            User::class,
            Municipio::class,
            'depar_iddepar', // Clave foránea en la tabla municipios
            'muni_idmuni',   // Clave foránea en la tabla usuarios
            'iddepar',       // Clave local en la tabla departamentos
            'idmuni'         // Clave local en la tabla municipios
        );
    }
}
