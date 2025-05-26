<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'usuarios';
    protected $primaryKey = 'idusu';

    public $timestamps = true;
    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null; // Assuming no updated_at based on other tables

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usua_nombre',
        'email',
        'password',
        'rol_idrol',
        'muni_idmuni',
        'estado',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'fecha_registro' => 'datetime',
            'estado' => 'string',
        ];
    }

    /**
     * Los atributos con valores por defecto.
     *
     * @var array
     */
    protected $attributes = [
        'estado' => 'Activo',
    ];

    // Add this method for Filament to get the user's display name
    public function getFilamentName(): string
    {
        return $this->usua_nombre;
    }

    // Add this method for Filament
    public function canAccessPanel(Panel $panel): bool
    {
        // Todos los usuarios pueden acceder al panel
        return true;
    }
    
    /**
     * Verifica si el usuario es administrador
     */
    public function isAdmin(): bool 
    {
        return $this->role && $this->role->rol_descripcion === 'Administrador';
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'rol_idrol', 'idrol');
    }

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class, 'muni_idmuni', 'idmuni');
    }

    /**
     * Obtener el departamento a través del municipio
     */
    public function departamento()
    {
        return $this->municipio ? $this->municipio->departamento : null;
    }

    // Relationships to financial tables
    public function ingresos(): HasMany
    {
        return $this->hasMany(Ingreso::class, 'usu_idusu', 'idusu');
    }

    public function egresos(): HasMany
    {
        return $this->hasMany(Egreso::class, 'usu_idusu', 'idusu');
    }

    public function inversiones(): HasMany
    {
        return $this->hasMany(Inversion::class, 'usu_idusu', 'idusu');
    }

    public function costosFijos(): HasMany
    {
        return $this->hasMany(CostoFijo::class, 'usu_idusu', 'idusu');
    }

    public function costosVariables(): HasMany
    {
        return $this->hasMany(CostoVariable::class, 'usu_idusu', 'idusu');
    }

    public function metasAhorro(): HasMany
    {
        return $this->hasMany(MetaAhorro::class, 'usu_idusu', 'idusu');
    }

    public function alertas(): HasMany
    {
        return $this->hasMany(Alerta::class, 'usu_idusu', 'idusu');
    }
}
