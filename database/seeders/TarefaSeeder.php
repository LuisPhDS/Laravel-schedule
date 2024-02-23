<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class TarefaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tarefas')->insert([
            [
                'id' => Uuid::uuid4()->toString(),
                'usuario_idUsuario' => 'a9af9b5b-68dc-47bb-b9b0-191f23edd7f8',
                'titulo' => 'Tarefa 1',
                'descricao' => 'Descrição da tarefa 1',
                'data_termino' => date('Y-m-d H:i:s'),
                'prioridade' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'usuario_idUsuario' => 'e32f6399-87e2-4eac-a4bc-494bc464b1ac',
                'titulo' => 'Tarefa 2',
                'descricao' => 'Descrição da tarefa 1',
                'data_termino' => date('Y-m-d H:i:s'),
                'prioridade' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'usuario_idUsuario' => 'c0ad9ddf-128c-4d44-8e14-bd4a87a92e9a',
                'titulo' => 'Tarefa 3',
                'descricao' => 'Descrição da tarefa 1',
                'data_termino' => date('Y-m-d H:i:s'),
                'prioridade' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'usuario_idUsuario' => 'a9af9b5b-68dc-47bb-b9b0-191f23edd7f8',
                'titulo' => 'Tarefa 4',
                'descricao' => 'Descrição da tarefa 1',
                'data_termino' => date('Y-m-d H:i:s'),
                'prioridade' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
