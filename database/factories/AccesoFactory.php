<?php

namespace Database\Factories;

use App\Models\Dispositivo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccesoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_usuario' => User::factory(),
            'id_dispositivo' => Dispositivo::factory(),
            'metodo' => fake()->randomElement(['pin', 'rfid', 'app']),
            'resultado' => fake()->randomElement(['exito', 'denegado']),
            'fecha_hora' => fake()->dateTimeThisMonth(),
        ];
    }
}
