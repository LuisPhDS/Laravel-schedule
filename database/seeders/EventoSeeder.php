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
                'usuario_idUsuario' => '803f1ac3-6ed6-4b60-9ece-8201b00dd5b7',

                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'usuario_idUsuario' => '922951ab-c5fc-4425-96c3-cbdba214ec67',

                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'usuario_idUsuario' => 'e41424f4-ca6b-445e-a649-ece14a3c6e03',

                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
