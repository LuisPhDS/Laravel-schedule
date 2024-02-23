@extends('templates/login_layout')
@section('content')
    <div class="login-wrapper">
        <div class="login-box">
            <h3 class="text-center">Login</h3>
                <hr>
            <form action="{{ route('login_submit') }}" method="post" class="formulario">
                @csrf
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuário:</label>
                    <div class="input-group">
                        <input type="text" name="usuario" id="usuario" placeholder="Usuário" class="form-control">
                        <span class="input-group-text"><i class="fa-solid fa-at"></i></span>
                    </div>
                    @error('usuario')
                        <div class="text-danger">{{ $errors->get('usuario')[0] }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha:</label>
                    <div class="input-group">
                        <input type="password" name="senha" id="senha" placeholder="Senha" class="form-control">
                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    </div>
                    @error('usuario')
                        <div class="text-danger">{{ $errors->get('usuario')[0] }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-outline-success"><i class="fa-solid fa-right-from-bracket"></i> Entrar</button>
                </div>

                @if (session()->has('login_error'))
                    <div class="alert alert-danger text-center p-1 ">
                        {!! session()->get('login_error') !!}
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection