<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('eventos')->insert([
            [
                'id' => Uuid::uuid4()->toString(),
                'usuario_idUsuario' => 'a9af9b5b-68dc-47bb-b9b0-191f23edd7f8',
                'titulo' => 'Título Evento 1',
                'descricao' => 'dDescrição Evento 1',

                'data_inicio' => now(),
                'hora_inicio' => now(),
                'data_termino' => now()->addDays(4),
                'hora_termino' => now()->addHours(4),
                'localidade' => 'Salvador',

                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'usuario_idUsuario' => 'e32f6399-87e2-4eac-a4bc-494bc464b1ac',
                'titulo' => 'Título Evento 2',
                'descricao' => 'dDescrição Evento 2',

                'data_inicio' => now(),
                'hora_inicio' => now(),
                'data_termino' => now()->addDays(4),
                'hora_termino' => now()->addHours(4),
                'localidade' => 'Salvador',

                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'usuario_idUsuario' => 'c0ad9ddf-128c-4d44-8e14-bd4a87a92e9a',
                'titulo' => 'Título Evento 3',
                'descricao' => 'dDescrição Evento 3',

                'data_inicio' => now(),
                'hora_inicio' => now(),
                'data_termino' => now()->addDays(4),
                'hora_termino' => now()->addHours(4),
                'localidade' => 'Salvador',

                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}