<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dispositivo extends Model
{
    use HasFactory;

    protected $table = 'dispositivos';
    protected $primaryKey = 'id_dispositivo';

    protected $fillable = [
        'id_usuario',
        'tipo',
        'ubicacion',
        'estado',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function eventos(): HasMany
    {
        return $this->hasMany(Evento::class, 'id_dispositivo', 'id_dispositivo');
    }

    public function accesos(): HasMany
    {
        return $this->hasMany(Acceso::class, 'id_dispositivo', 'id_dispositivo');
    }
}
