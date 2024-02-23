<?php

namespace App\Http\Controllers;

use App\Models\TarefaModel;
use Illuminate\Http\Request;

class Main extends Controller
{
    public function index(){
        $data = [
            'title' => 'Agenda Saeb',
        ];

        // Buscar tarefas
        $model = new TarefaModel();
        $tarefas = $model->where('usuario_idUsuario', '=', session('id'))
                        ->whereNull('deleted_at')
                        ->get();
        
        $data['tarefas'] = $this->_get_tarefas($tarefas);

        return view('index', $data);
    }

// =========================================== 
// Métodos Privados 
// ===========================================
    private function _get_tarefas($tarefas){
        $colecao = [];

        foreach($tarefas as $tarefa){
            $link_editar = '<a class="btn btn-outline-warning m-1" href=""><i class="fa-regular fa-pen-to-square"></i></a>';
            $link_deletar = '<a class="btn btn-outline-danger m-1" href=""><i class="fa-regular fa-trash-can"></i></a>';

            $colecao[] = [
                'tarefa_titulo' => '<span class="titulo_tarefa">'. $tarefa->titulo .'</span>',
                'tarefa_descricao' => '<small class="opacity-50">'. $tarefa->descricao .'</small>',
                'tarefa_status' => '<span>'. $tarefa->prioridade .'</span>',
                'tarefa_acao' => $link_editar . $link_deletar
            ];
        }

        return $colecao;
    }    

}