<?php

namespace Database\Seeders;

use App\Models\Acceso;
use App\Models\Alerta;
use App\Models\Dispositivo;
use App\Models\Evento;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear un administrador de prueba
        $admin = User::factory()->create([
            'nombre' => 'Admin Test',
            'email' => 'admin@example.com',
            'rol' => 'admin',
        ]);

        // Crear usuarios de prueba
        $usuarios = User::factory(5)->create();
        $usuarios->push($admin);

        // Crear dispositivos para los usuarios
        foreach ($usuarios as $usuario) {
            $dispositivos = Dispositivo::factory(3)->create([
                'id_usuario' => $usuario->id_usuario,
            ]);

            // Generar eventos y accesos para cada dispositivo
            foreach ($dispositivos as $dispositivo) {
                $eventos = Evento::factory(5)->create([
                    'id_dispositivo' => $dispositivo->id_dispositivo,
                ]);

                Acceso::factory(2)->create([
                    'id_usuario' => $usuario->id_usuario,
                    'id_dispositivo' => $dispositivo->id_dispositivo,
                ]);

                // Generar alertas a partir de algunos eventos críticos o warnings
                foreach ($eventos as $evento) {
                    if (in_array($evento->nivel, ['warning', 'critical'])) {
                        Alerta::factory()->create([
                            'id_evento' => $evento->id_evento,
                            'id_usuario' => $usuario->id_usuario,
                            'mensaje' => 'Alerta generada por evento: '.$evento->tipo_evento,
                        ]);
                    }
                }
            }
        }
    }
}
