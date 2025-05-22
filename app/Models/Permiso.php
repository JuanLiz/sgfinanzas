<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permiso extends Model
{
    use HasFactory;

    protected $table = 'permisos';
    protected $primaryKey = 'idper';

    public $timestamps = true;
    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = [
        'permiscol',
        'estado',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'estado' => 'string',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'roles_has_modulos', 'per_idper', 'rol_idrol')
                    ->withTimestamps(false);
    }

    public function modulos(): BelongsToMany
    {
        return $this->belongsToMany(Modulo::class, 'roles_has_modulos', 'per_idper', 'mod_idmodu')
                    ->withTimestamps(false);
    }
}
