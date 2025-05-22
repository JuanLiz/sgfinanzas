<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Modulo extends Model
{
    use HasFactory;

    protected $table = 'modulos';
    // La clave primaria debe coincidir con la columna en la base de datos.
    // Si la migración original creó 'idmod' y no la hemos renombrado explícitamente a 'idmodu' en una migración,
    // entonces el primaryKey debería ser 'idmod'.
    // Si la nueva migración o una anterior se encarga de renombrar 'idmod' a 'idmodu',
    // entonces 'idmodu' es correcto.
    // Por ahora, lo mantendremos como 'idmodu' asumiendo que la intención es estandarizar.
    protected $primaryKey = 'idmodu';

    public $timestamps = true;
    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null; // Explicitly set to null if you don't have an updated_at column

    protected $fillable = [
        'modu_nombre',
        'modu_descripcion',
        'modu_icono',
        'modu_orden',
        'estado',
        // No es necesario 'idmodu' en fillable si es autoincremental
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'estado' => 'string',
        'modu_orden' => 'integer',
    ];

    public function roles(): BelongsToMany
    {
        // Asegúrate que la clave foránea 'mod_idmodu' en la tabla pivote 'roles_has_modulos'
        // coincida con la clave primaria de esta tabla ('idmodu').
        return $this->belongsToMany(Role::class, 'roles_has_modulos', 'mod_idmodu', 'rol_idrol')
                    ->withPivot('permisos')
                    ->withTimestamps('fecha_asignacion_modulo', null);
    }

    /**
     * Obtiene los permisos definidos para este módulo.
     */
    public function permisosDefinidos(): \Illuminate\Database\Eloquent\Relations\HasMany // Renombrado para claridad
    {
        // Un módulo tiene muchos permisos (que se definen para él).
        // La clave foránea en la tabla 'permisos' debe ser 'idmodu' (o como se llame allí).
        return $this->hasMany(Permiso::class, 'idmodu', 'idmodu');
    }
}
