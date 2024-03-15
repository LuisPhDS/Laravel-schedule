<?php

namespace App\Http\Controllers;

use App\Models\ContatoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class Contato extends Controller
{
// =========================================== 
// CONTATOS - Listagem 
// ===========================================
    public function contatos(){
        $data = [
            'title' => 'Agenda Saeb',
        ];

        $model = new ContatoModel();
        $contatos = $model->where('usuario_idUsuario', '=', session('id'))
                          ->whereNull('deleted_at')
                          ->orderBy('id')->paginate(5);

        $contatos->withPath(route('contatos'));
        // dd($data['contatos']);
        $data['contatos'] = $this->_get_contatos($contatos);
        $data['contatos_paginados'] = $contatos;
       
        
        return view('contatos/lista', $data);
    }

// =========================================== 
// CONTATOS - Criar
// ===========================================
    public function novo_contato(){
        $data = [
            'title' => 'Agenda Saeb',
        ];

        return view('contatos/criar', $data);
    }

    public function novo_contato_submit(Request $request){
        $request->validate([
            'contato_nome' => 'required|min:6|max:65',
            'contato_tel' => 'required|min:6|max:15',
            'contato_email' => 'required|min:6|email|unique:contatos,email',
            'contato_imagem' => 'image|mimes:jpeg,png,jpg'
        ],[
            'contato_nome.required' => 'O campo é de preenchimento obrigatório',
            'contato_nome.min' => 'O campo deve ter no mínimo :min caracteres',
            'contato_nome.max' => 'O campo deve ter no mínimo :max caracteres',

            'contato_tel.required' => 'O campo é de preenchimento obrigatório',
            'contato_tel.min' => 'O campo deve ter no mínimo :min caracteres',
            'contato_tel.max' => 'O campo deve ter no mínimo :max caracteres',

            'contato_email.required' => 'O campo é de preenchimento obrigatório',
            'contato_email.email' => 'O campo deve ter um e-mail válido',

            'contato_imagem.image' => 'O arquivo deve ser uma imagem',
            'contato_imagem.mimes' => 'Os arquivos aceitos são .jpeg, .png, .jpg',
        ]);

        // capturando os dados do formulário
        $contato_nome = $request->input('contato_nome');
        $contato_tel = $request->input('contato_tel');
        $contato_email = $request->input('contato_email');
        $contato_imagem = $request->input('contato_imagem');

       

        return  dd($contato_email);
    }

// =========================================== 
// Métodos Privados 
// ===========================================
    private function _get_contatos($contatos){
        $colecao = [];

        foreach($contatos as $contato){
            $link_editar = '<a class="btn btn-outline-warning m-1" href=""><i class="fa-regular fa-pen-to-square"></i></a>';
            /* '. route('editar_tarefa', ['id' => Crypt::encrypt($tarefa->id)]) .' */

            /* Botão gatilho do modal de deleção */
            $link_deletar = '<button type="button" class="btn btn-outline-danger m-1" data-bs-toggle="modal" data-bs-target="#modalDelecao">
                                <i class="fa-regular fa-trash-can"></i>
                             </button>';
                             /* '. $tarefa->id .' */
            $link_email = '<a href="mailto:'. $contato->email .'">'. $contato->email .'</a>';
            $link_tel = '<a href="tel:+55'. $contato->telefone .'"><span class="opacity-50">'. $contato->telefone .'</span></a>';
 
            $colecao[] = [
                'contato_id' => $contato->id,
                'contato_id_crypt' => Crypt::encrypt($contato->id),
                'contato_nome' => '<span class="nome_contato">'. $contato->nome .'</span>',
                'contato_telefone' => $link_tel,
                'contato_imagem' => $contato->imagem ? $contato->imagem : "assets/img/imgProfile/1defaultImg.svg",
                'contato_email' => $link_email,
                'contato_acao' => $link_editar . $link_deletar,
            ];
        }

        return $colecao;
    }
}
