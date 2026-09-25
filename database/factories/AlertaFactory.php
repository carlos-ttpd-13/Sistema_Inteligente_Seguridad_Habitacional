<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlertaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_evento' => Evento::factory(),
            'id_usuario' => User::factory(),
            'mensaje' => fake()->sentence(),
            'canal' => fake()->randomElement(['web', 'email', 'sms', 'push']),
            'leida' => fake()->boolean(20), // 20% chance to be true
            'fecha' => fake()->dateTimeThisMonth(),
        ];
    }
}
