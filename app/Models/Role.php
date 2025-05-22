<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'idrol';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The name of the "created at" column.
     *
     * @var string|null
     */
    const CREATED_AT = 'fecha_registro';

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    const UPDATED_AT = null;

    protected $fillable = [
        'rol_descripcion',
        'estado',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'estado' => 'string',
    ];

    /**
     * Get the users for this role.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'rol_idrol', 'idrol');
    }

    /**
     * The modulos that belong to the role.
     */
    public function modulos(): BelongsToMany
    {
        return $this->belongsToMany(Modulo::class, 'roles_has_modulos', 'rol_idrol', 'mod_idmodu')
                    ->withPivot('per_idper')
                    ->withTimestamps(false);
    }

    /**
     * The permissions associated with this role through modules.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permiso::class, 'roles_has_modulos', 'rol_idrol', 'per_idper')
                    ->withTimestamps(false);
    }
}
