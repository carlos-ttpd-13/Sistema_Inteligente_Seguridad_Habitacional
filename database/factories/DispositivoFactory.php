<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DispositivoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_usuario' => User::factory(),
            'tipo' => fake()->randomElement(['ESP32', 'PIR', 'Magnético', 'Buzzer', 'LED', 'Teclado']),
            'ubicacion' => fake()->randomElement(['Puerta Principal', 'Ventana Sala', 'Habitación 1', 'Pasillo']),
            'estado' => fake()->randomElement(['activo', 'inactivo']),
        ];
    }
}
