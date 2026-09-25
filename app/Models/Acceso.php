<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Acceso extends Model
{
    use HasFactory;

    protected $table = 'accesos';

    protected $primaryKey = 'id_acceso';

    protected $fillable = [
        'id_usuario',
        'id_dispositivo',
        'metodo',
        'resultado',
        'fecha_hora',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function dispositivo(): BelongsTo
    {
        return $this->belongsTo(Dispositivo::class, 'id_dispositivo', 'id_dispositivo');
    }
}
