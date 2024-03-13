<?php

namespace App\Http\Controllers;

use App\Models\UsuarioModel;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class Login extends Controller
{
    public function login(){
        $data = [
            'title' => 'Login'
        ];

        return view('login', $data);
    }

    public function login_submit(Request $request){
        // validar o formulário
        $request->validate([
            'usuario' => 'required|min:3',
            'senha' => 'required|min:3'
        ],[
            'usuario.required' => 'O campo é de preenchimento obrigatório',
            'usuario.min' => 'O campo deve ter no mínimo :min caracteres',

            'senha.required' => 'O campo é de preenchimento obrigatório',
            'senha.min' => 'O campo deve ter no mínimo :min caracteres',
        ]);

        // capturando os dados do formulário
        $usuario = $request->input('usuario');
        $senha = $request->input('senha');

        // verificar se o usuário existe
        $model = new UsuarioModel();
        $user = $model->where(function ($query) use ($usuario) { //compara com o e-mail ou o nome
                                $query->where('email', $usuario)
                                ->orWhere('nome', $usuario);
                        })
                      ->whereNull('deleted_at')
                      ->first();
        // Verificar se a senha está correta
        if($user){
            if(password_verify($senha, $user->senha)){
                $session_data = [
                    'id' => $user->id,
                    'nome' => $user->nome,
                ];
                // inserindo os dados na sessão
                session()->put($session_data);
                return redirect()->route('index');
            }
        }
        

        // Login inválido
        return redirect()->route('login')
                         ->withInput()
                         ->with('login_error', "Login inválido! <br> <small class='mt-2'>verifique se o usuário e a senha estão corretos</small>");
    }

    public function logout(){
        session()->forget('nome');

        return redirect()->route('login');
    }

    public function signin(){
        $data = [
            'title' => 'Cadastrar-se',
        ];

        return view('signin', $data);
    }

    public function novo_usuario_submit(Request $request){
        $request->validate([
            'nome_usuario' => 'required|min:6',
            'senha_usuario' => 'required|min:6',
            'email_usuario' => 'required|min:6|email|unique:usuarios,email',
        ],[
            'nome_usuario.required' => 'O campo é de preenchimento obrigatório',
            'nome_usuario.min' => 'O campo deve ter no mínimo :min caracteres',

            'senha_usuario.required' => 'O campo é de preenchimento obrigatório',
            'senha_usuario.min' => 'O campo deve ter no mínimo :min caracteres',

            'email_usuario.required' => 'O campo é de preenchimento obrigatório',
            'email_usuario.min' => 'O campo deve ter no mínimo :min caracteres',
            'email_usuario.unique' => 'O e-mail não pode ser cadastrado',
            'email_usuario.email' => 'O e-mail deve ser válido',
        ]);

        // capturando os dados do formulário
        $nome_usuario = $request->input('nome_usuario');
        $email_usuario = $request->input('email_usuario');
        $senha_usuario = $request->input('senha_usuario');

        // Inserir os dados na tabela
        $model = new UsuarioModel();
        $model->id = Uuid::uuid4()->toString();
        $model->nome = htmlspecialchars($nome_usuario);
        $model->email = htmlspecialchars($email_usuario);
        $model->senha = password_hash(htmlspecialchars($senha_usuario), PASSWORD_DEFAULT);
        $model->created_at = date('Y-m-d H:i:s');
        $model->save();

        return redirect()->route('signin')
                         ->withInput()
                         ->with('sucesso_usuario', 'Conta criada com sucesso!');
    }
}
