<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    
        DB::table('usuarios')->insert([
            [
                'id' => Uuid::uuid4()->toString(),
                'nome' => 'administrador',
                'email' => 'adm@gmail.com',
                'senha' => password_hash('adm123', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            ],[
                'id' => Uuid::uuid4()->toString(),
                'nome' => 'Luís Phillipe',
                'email' => 'luis@gmail.com',
                'senha' => password_hash('luis123', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            ],[
                'id' => Uuid::uuid4()->toString(),
                'nome' => 'João José',
                'email' => 'joao@gmail.com',
                'senha' => password_hash('joao123', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
