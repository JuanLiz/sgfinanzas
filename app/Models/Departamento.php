<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departamento extends Model
{
    use HasFactory;

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
