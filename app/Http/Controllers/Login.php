<?php

namespace App\Http\Controllers;

use App\Models\UsuarioModel;
use Illuminate\Http\Request;

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
}
