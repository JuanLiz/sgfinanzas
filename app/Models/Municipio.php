<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Municipio extends Model
{
    use HasFactory;

    protected $table = 'municipios';
    protected $primaryKey = 'idmuni';

    public $timestamps = true;
    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = null;

    protected $fillable = [
        'muni_nombre',
        'depar_iddepar',
        'estado',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'estado' => 'string',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'muni_idmuni', 'idmuni');
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'depar_iddepar', 'iddepar');
    }
}