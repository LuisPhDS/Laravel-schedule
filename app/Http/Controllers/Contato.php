<?php

namespace App\Http\Controllers;

use App\Models\ContatoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class Contato extends Controller
{
// =========================================== 
// CONTATOS - Listagem 
// ===========================================
    public function contatos(){
        $data = [
            'title' => 'Agenda Saeb',
            'filtro' => "",
        ];

        // Verificar se houve pesquisa
        if(session('filtro')){
            $model = new ContatoModel();
            $contatos = session('contatos');
            $data['contatos'] = $this->_get_contatos(session('contatos'));
            // dd($contatos, $data['contatos']);
            $data['pesquisa'] = session('filtro');


            $data['contatos_paginados'] = $contatos;
            // limpar sessão
            session()->forget('filtro');
            session()->forget('contatos');
        } else {
            $model = new ContatoModel();
            $contatos = $model->where('usuario_idUsuario', '=', session('id'))
                              ->whereNull('deleted_at')
                              ->orderBy('id')->paginate(5);
    
            $contatos->withPath(route('contatos'));
            // dd($contatos, session('filtro'));
            $data['contatos'] = $this->_get_contatos($contatos);
            $data['contatos_paginados'] = $contatos;
        }
        
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
            'contato_imagem' => 'nullable|image|mimes:jpeg,png,jpg'
        ],[
            'contato_nome.required' => 'O campo é de preenchimento obrigatório.',
            'contato_nome.min' => 'O campo deve ter no mínimo :min caracteres.',
            'contato_nome.max' => 'O campo deve ter no mínimo :max caracteres.',

            'contato_tel.required' => 'O campo é de preenchimento obrigatório.',
            'contato_tel.min' => 'O campo deve ter no mínimo :min caracteres.',
            'contato_tel.max' => 'O campo deve ter no mínimo :max caracteres.',

            'contato_email.required' => 'O campo é de preenchimento obrigatório.',
            'contato_email.email' => 'O campo deve ter um e-mail válido.',

            'contato_imagem.image' => 'O arquivo deve ser uma imagem.',
            'contato_imagem.mimes' => 'Os arquivos aceitos são .jpeg, .png, .jpg',
        ]);
        
        // Inicializa a variável $nomeArquivo com um valor padrão
        $nomeArquivo = null;

        // capturando os dados do formulário
        $contato_nome = $request->input('contato_nome');
        $contato_tel = $request->input('contato_tel');
        $contato_email = $request->input('contato_email');
        
        // Verificar se já existe um contato com esse e-mail para o mesmo usuário
        $model = new ContatoModel();
        $contato = $model->where('usuario_idUsuario', '=', session('id'))
                         ->where('email', '=', $contato_email)
                         ->whereNull('deleted_at')
                         ->first();
        if($contato){
            return redirect()->route('novo_contato')
                             ->withInput()
                             ->with('error_contato', 'Já existe um contato com esse email.');
        }

        // captura o dado da imagem passado
        if ($request->hasFile('contato_imagem')){
            $contato_imagem = $request->file('contato_imagem');
            // Normaliza o nome do arquivo
            $nomeArquivo = Str::uuid() . '.' . $contato_imagem->getClientOriginalExtension();
            // Salva o arquivo na pasta de destino
            $contato_imagem->move(public_path('assets/img/imgProfileContatos'), $nomeArquivo);
        }

        // Formatando número
        // $phoneUtil = PhoneNumberUtil::getInstance();
        // $number = $phoneUtil->parse($contato_tel, "BR");
        // $numeroFormatado = $phoneUtil->format($number, PhoneNumberFormat::INTERNATIONAL);

        // Inserir os dados na tabela
        $model->id = Uuid::uuid4()->toString();
        $model->usuario_idUsuario = session('id');
        $model->nome = htmlspecialchars($contato_nome);
        $model->telefone = htmlspecialchars($contato_tel);
        $model->imagem = $nomeArquivo ? 'assets/img/imgProfileContatos/'.$nomeArquivo : 'assets/img/imgProfileContatos/1defaultImg.svg';
        $model->created_at = date('Y-m-d H:i:s');
        $model->email = $contato_email;
        $model->save();
        // return  dd($model->id, 
        //             $model->usuario_idUsuario,  
        //             $model->nome, 
        //             $model->telefone, 
        //             $model->imagem,
        //             $model->created_at,
        //             $model->email
        //         );
        return redirect()->route('contatos')
                         ->withInput()
                         ->with('sucesso_contato', 'Contato registrado!');
    }

// =========================================== 
// CONTATOS - Atualizar
// ===========================================
    public function editar_contato($id){
        try {
            $id_contato = Crypt::decrypt($id);

        } catch (\Exception $e) {

            return redirect()->route('contatos');
        }

        //capturar dados enviados do contato
        $model = new ContatoModel();
        $contato = $model->where('id', '=', $id_contato)
                        ->whereNull('deleted_at')
                        ->first();
        
        // Verificar se o contato existe
        if(empty($contato)){
            return redirect()->route('contatos');
        }

        // envia os dados para a view do formulario de atualização
        $data = [
            'title' => "Editar Contato",
            'contato' => $contato
        ];
        // dd($contato, $data);

        return view('contatos/editar', $data);
    }

    public function editar_contato_subimit(Request $request){
        $id_contato = null;
        try {
            $id_contato = Crypt::decrypt($request->input('id_contato'));

        } catch (\Exception $e) {
            return redirect()->route('contatos');
        }

        // Validar formulário
        $request->validate([
            'contato_nome' => 'required|min:6|max:65',
            'contato_tel' => 'required|min:6|max:15',
            'contato_email' => [
                'required',
                'min:6',
                'email',
                Rule::unique('contatos', 'email')->ignore($id_contato),
            ],
            'contato_imagem' => 'nullable|image|mimes:jpeg,png,jpg'
        ],[
            'contato_nome.required' => 'O campo é de preenchimento obrigatório.',
            'contato_nome.min' => 'O campo deve ter no mínimo :min caracteres.',
            'contato_nome.max' => 'O campo deve ter no mínimo :max caracteres.',

            'contato_tel.required' => 'O campo é de preenchimento obrigatório.',
            'contato_tel.min' => 'O campo deve ter no mínimo :min caracteres.',
            'contato_tel.max' => 'O campo deve ter no mínimo :max caracteres.',

            'contato_email.required' => 'O campo é de preenchimento obrigatório.',
            'contato_email.email' => 'O campo deve ter um e-mail válido.',
            'contato_email.unique' => 'O campo deve ter um e-mail válido.',

            'contato_imagem.image' => 'O arquivo deve ser uma imagem.',
            'contato_imagem.mimes' => 'Os arquivos aceitos são .jpeg, .png, .jpg',
        ]);

        // Inicializa a variável $nomeArquivo com um valor padrão
        $nomeArquivo = null;

        // capturando os dados do formulário
        $contato_nome = $request->input('contato_nome');
        $contato_tel = $request->input('contato_tel');
        $contato_email = $request->input('contato_email');
        
        
        // Verificar se já existe um contato com esse e-mail para o mesmo usuário
        $model = new ContatoModel();
        $contato = $model->where('usuario_idUsuario', '=', session('id'))
                         ->where('email', '=', $contato_email)
                         ->where('id', '!=', $id_contato)
                         ->whereNull('deleted_at')
                         ->first();
        if($contato){
            return redirect()->route('editar_contato')
                             ->withInput()
                             ->with('error_contato', 'Já existe um contato com esse email.');
        }

        // captura o dado da imagem passado
        if ($request->hasFile('contato_imagem')){
            $contato_imagem = $request->file('contato_imagem');
            // Normaliza o nome do arquivo
            $nomeArquivo = Str::uuid() . '.' . $contato_imagem->getClientOriginalExtension();
            // Salva o arquivo na pasta de destino
            $contato_imagem->move(public_path('assets/img/imgProfileContatos'), $nomeArquivo);
        }

        // Atualizar o contato
        $model->where('id', '=', $id_contato)
                ->update([
                    'nome' => $contato_nome,
                    'telefone' => $contato_tel,
                    'imagem' => $nomeArquivo ? 'assets/img/imgProfileContatos/'.$nomeArquivo : 'assets/img/imgProfileContatos/1defaultImg.svg',
                    'email' => $contato_email,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

        return redirect()->route('contatos')
                        ->withInput()
                        ->with('sucesso_contato', 'Contato Atualizado!');
    }

// =========================================== 
// CONTATOS - Excluir
// ===========================================
    public function excluir_contato_confirmar($id){
        $id_contato = null;
        try {
            $id_contato = Crypt::decrypt($id);
        } catch (\Exception $e) {
            return redirect()->route('contatos');
        }

        // Excluir o contato com soft delete
        $model = new ContatoModel();
        $model->where('id', '=', $id_contato)
                ->update([
                    'deleted_at' => date('Y-m-d H:i:s')
                ]);
        
        return redirect()->route('contatos')
                         ->withInput()
                         ->with('sucesso_contato', 'Contato excluído!');
    }


// =========================================== 
// Contatos - Filtro
// ===========================================
    public function filtro(Request $request){
        $pesquisa = $request->input('filtro');
        
        // buscar os contatos
        $model = new ContatoModel();
        if($pesquisa == ""){
            $contatos = $model->where('usuario_idUsuario', '=', session('id'))
                              ->whereNull('deleted_at')
                              ->paginate(5);
        } else {
            $contatos = $model->where('usuario_idUsuario', '=', session('id'))
                              ->where('nome', 'like', '%'. $pesquisa . '%')
                              ->orWhere('email', 'like', '%'. $pesquisa .'%')                              
                              ->whereNull('deleted_at')
                              ->paginate(5);
        }
        // dd($pesquisa, $contatos,  $request->input('filtro'));
        session()->put('contatos', $contatos);
        session()->put('filtro', $pesquisa);

        return redirect()->route('contatos');
    }

// =========================================== 
// Métodos Privados 
// ===========================================
    private function _get_contatos($contatos){
        $colecao = [];

        foreach($contatos as $contato){
            $link_editar = '<a class="btn btn-outline-warning m-1" href="'. route('editar_contato', ['id' => Crypt::encrypt($contato->id)]) .'"><i class="fa-regular fa-pen-to-square"></i></a>';

            /* Botão gatilho do modal de deleção */
            $link_deletar = '<button type="button" class="btn btn-outline-danger m-1" data-bs-toggle="modal" data-bs-target="#modalDelecao'. $contato->id .'">
                                <i class="fa-regular fa-trash-can"></i>
                             </button>';

            $link_email = '<a href="mailto:'. $contato->email .'">'. $contato->email .'</a>';
            $link_tel = '<a href="tel:+55'. $contato->telefone .'"><span class="opacity-50">'. $contato->telefone .'</span></a>';
 
            $colecao[] = [
                'contato_id' => $contato->id,
                'contato_id_crypt' => Crypt::encrypt($contato->id),
                'contato_nome' => '<span class="nome_contato">'. $contato->nome .'</span>',
                'contato_telefone' => $link_tel,
                'contato_imagem' => $contato->imagem ? $contato->imagem : "assets/img/imgProfileContatos/1defaultImg.svg",
                'contato_email' => $link_email,
                'contato_acao' => $link_editar . $link_deletar,
            ];
        }

        return $colecao;
    }
}
