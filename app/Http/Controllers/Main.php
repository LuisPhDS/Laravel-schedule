<?php

namespace App\Http\Controllers;

use App\Models\TarefaModel;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class Main extends Controller
{
// =========================================== 
// Inicio 
// ===========================================
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
// TAREFAS - criar 
// ===========================================
    public function nova_tarefa(){
        $data =[
            'title' => 'Criar Tarefa'
        ];

        return view('nova_tarefa_form', $data);
    }
    
    public function nova_tarefa_submit(Request $request){
        $request->validate([
            'titulo_tarefa' => 'required|min:3|max:45',
            'descricao_tarefa' => 'required|min:3',
            'prioridade_tarefa' => 'required',
            'data_termino_tarefa' => 'required',
        ],[
            'titulo_tarefa.required' => 'O campo é de preenchimento obrigatório',
            'titulo_tarefa.min' => 'O campo deve ter no mínimo :min caracteres',
            'titulo_tarefa.max' => 'O campo deve ter no máximo :max caracteres',

            'descricao_tarefa.required' => 'O campo é de preenchimento obrigatório',
            'descricao_tarefa.min' => 'O campo deve ter no mínimo :min caracteres',

            'prioridade_tarefa.required' => 'O campo é de preenchimento obrigatório',

            'data_termino_tarefa.required' => 'O campo é de preenchimento obrigatório',
        ]);

        // capturando os dados do formulário
        $titulo_tarefa = $request->input('titulo_tarefa');
        $descricao_tarefa = $request->input('descricao_tarefa');
        $prioridade_tarefa = $request->input('prioridade_tarefa');
        $data_termino_tarefa = $request->input('data_termino_tarefa');

        // Verificar se já existe uma tarefa com esse nome para o mesmo usuário
        $model = new TarefaModel();
        $tarefa = $model->where('usuario_idUsuario', '=', session('id'))
                        ->where('titulo', '=', $titulo_tarefa)
                        ->whereNull('deleted_at')
                        ->first();
        if($tarefa){
            return redirect()->route('nova_tarefa')
                             ->withInput()
                             ->with('error_tarefa', 'Já existe uma tarefa com esse nome.');
        }

        // Inserir os dados na tabela
        $model->id = Uuid::uuid4()->toString();
        $model->usuario_idUsuario = session('id');
        $model->titulo = htmlspecialchars($titulo_tarefa);
        $model->descricao = htmlspecialchars($descricao_tarefa);
        $model->data_termino = $data_termino_tarefa;
        $model->prioridade = $prioridade_tarefa;
        $model->created_at = date('Y-m-d H:i:s');
        $model->save();

        return redirect()->route('index');
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