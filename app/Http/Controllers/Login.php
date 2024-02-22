<?php

namespace App\Http\Controllers;

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

        // verificação do usuario
        

        // Login inválido
        return redirect()->route('login')
                         ->withInput()
                         ->with('login_error', 'Login inválido');
    }
}
