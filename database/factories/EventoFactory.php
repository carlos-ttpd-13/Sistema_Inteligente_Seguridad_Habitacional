<?php

namespace Database\Factories;

use App\Models\Dispositivo;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_dispositivo' => Dispositivo::factory(),
            'tipo_evento' => fake()->randomElement(['movimiento_detectado', 'puerta_abierta', 'puerta_cerrada', 'alarma_activada', 'error_conexion']),
            'nivel' => fake()->randomElement(['info', 'warning', 'critical']),
            'fecha_hora' => fake()->dateTimeThisMonth(),
            'descripcion' => fake()->sentence(),
        ];
    }
}
