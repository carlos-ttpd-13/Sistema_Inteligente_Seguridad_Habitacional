<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';
    protected $primaryKey = 'id_evento';

    protected $fillable = [
        'id_dispositivo',
        'tipo_evento',
        'nivel',
        'fecha_hora',
        'descripcion',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    public function dispositivo(): BelongsTo
    {
        return $this->belongsTo(Dispositivo::class, 'id_dispositivo', 'id_dispositivo');
    }

    public function alertas(): HasMany
    {
        return $this->hasMany(Alerta::class, 'id_evento', 'id_evento');
    }
}
