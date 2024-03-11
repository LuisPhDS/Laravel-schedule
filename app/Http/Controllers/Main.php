<?php

namespace App\Http\Controllers;

use App\Models\TarefaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
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

        // Verificar se houve pesquisa
        if(session('filtro')){
            $data['filtro'] = session('filtro');
            $data['tarefas'] = $this->_get_tarefas(session('tarefas'));

            // limpar sessão
            session()->forget('filtro');
            session()->forget('tarefas');
        } else {
            // Buscar tarefas
            $model = new TarefaModel();
            $tarefas = $model->where('usuario_idUsuario', '=', session('id'))
                            ->whereNull('deleted_at')
                            ->get();
            
            $data['tarefas'] = $this->_get_tarefas($tarefas);
        }


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
// TAREFAS - editar 
// ===========================================
    public function editar_tarefa($id){
        try{

            $id = Crypt::decrypt($id);

        } catch (\Exception $e){
            
            return redirect()->route('index');

        }

        // Capturando os dados da tarefa enviada
        $model = new TarefaModel();
        $tarefa = $model->where('id', '=', $id)
                        ->whereNull('deleted_at')
                        ->first();

        // Verificar se a tarefa existe
        if(empty($tarefa)){
            return redirect()->route('index');
        }


        // envia os dados para a view do formulario de atualização
        $data = [
            'title' => "Editar Tarefa",
            'tarefa' => $tarefa
        ];

        return view('editar_tarefa_form', $data);
    }

    public function editar_tarefa_subimit(Request $request){
        // Validação do formulário
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

        // Capturar os dados do formulário
        $id_tarefa = null;
        try{

            $id_tarefa = Crypt::decrypt($request->input('id_tarefa'));

        } catch (\Exception $e){

            return redirect()->route('index');

        }
        $titulo_tarefa = $request->input('titulo_tarefa');
        $descricao_tarefa = $request->input('descricao_tarefa');
        $prioridade_tarefa = $request->input('prioridade_tarefa');
        $data_termino_tarefa = $request->input('data_termino_tarefa');

        // Verificar se há outra tarefa com o mesmo nome para o mesmo usuário
        $model = new TarefaModel();
        $tarefa = $model->where('usuario_idUsuario', '=', session('id'))
                        ->where('titulo', '=', $titulo_tarefa)
                        ->where('id', '!=', $id_tarefa)
                        ->whereNull('deleted_at')
                        ->first();
        
        if($tarefa){
            return redirect()
                    ->route('editar_tarefa', ['id' => Crypt::encrypt($id_tarefa)])
                    ->with('error_tarefa', "Já existe uma tarefa com o mesmo nome.");
        }

        // Atualiza a tarefa
        $model->where('id', '=', $id_tarefa)
                ->update([
                    'titulo' => $titulo_tarefa,
                    'descricao' => $descricao_tarefa,
                    'prioridade' => $prioridade_tarefa,
                    'data_termino' => $data_termino_tarefa,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

        return redirect()->route('index');

        // dd([
            // $titulo_tarefa ,
            // $descricao_tarefa ,
            // $prioridade_tarefa,
            // $data_termino_tarefa
        // ]);
        // echo '<pre>';
        // print_r($request->all());
    }

// =========================================== 
// TAREFAS - excluir
// ===========================================
    public function excluir_tarefa($id){
        try{

            $id = Crypt::decrypt($id);

        } catch (\Exception $e){

            return redirect()->route('index');

        }

        // captura dos dados da tarefa
        $model = new TarefaModel();
        $tarefa = $model->where('id', '=', $id)->first();

        // verificar se a tarefa existe
        if(!$tarefa){
            return redirect()->route('index');
        }

        $data = [
            'tarefa' => $tarefa
        ];

        return view('index', $data);
    }

    public function excluir_tarefa_confirmar($id){
        $id_tarefa = null;
        try{

            $id_tarefa = Crypt::decrypt($id);

        } catch(\Exception $e){

            return redirect()->route('index');

        }

        // excluir tarefa com soft delete
        $model = new TarefaModel();
        $model->where('id', '=', $id_tarefa)
                ->update([
                    'deleted_at' => date('Y-m-d H:i:s')
                ]);
        
        /* // busca as tarefas do usuário
        $tarefas = $model->where('usuario_idUsuario', '=', session('id'))
                        ->whereNull('deleted_at')
                        ->get();
        $data['tarefas'] = $this->_get_tarefas($tarefas);*/

        return redirect()->route('index'); 
    }

// =========================================== 
// TAREFAS - filtro
// ===========================================
    public function filtro($prioridade){
        // Descriptografar a prioridade
        /* try {
            $prioridade = Crypt::decrypt($prioridade);
        } catch (\Exception $e) {
            return redirect()->route('index');
        } */

        // buscar as tarefas
        $model = new TarefaModel();
        if($prioridade == 'all'){
            $tarefas = $model->where('usuario_idUsuario', '=', session('id'))
                             ->whereNull('deleted_at')
                             ->get();
        } else {
            $tarefas = $model->where('usuario_idUsuario', '=', session('id'))
                             ->where('prioridade', '=', $prioridade)
                             ->whereNull('deleted_at')
                             ->get();
        }

        session()->put('tarefas', $tarefas);
        session()->put('filtro', $prioridade);

        return redirect()->route('index');
    }

// =========================================== 
// Métodos Privados 
// ===========================================
    private function _get_tarefas($tarefas){
        $colecao = [];

        foreach($tarefas as $tarefa){
            $link_editar = '<a class="btn btn-outline-warning m-1" href="'. route('editar_tarefa', ['id' => Crypt::encrypt($tarefa->id)]) .'"><i class="fa-regular fa-pen-to-square"></i></a>';

            /* Botão gatilho do modal de deleção */
            $link_deletar = '<button type="button" class="btn btn-outline-danger m-1" data-bs-toggle="modal" data-bs-target="#modalDelecao'. $tarefa->id .'">
                                <i class="fa-regular fa-trash-can"></i>
                             </button>';
            
            $colecao[] = [
                'tarefa_id' => $tarefa->id,
                'tarefa_titulo' => '<span class="titulo_tarefa">'. $tarefa->titulo .'</span>',
                'tarefa_descricao' => '<small class="opacity-50">'. $tarefa->descricao .'</small>',
                'tarefa_prioridade' => '<span>'. $tarefa->prioridade .'</span>',
                'tarefa_acao' => $link_editar . $link_deletar
            ];
        }

        return $colecao;
    }    
}