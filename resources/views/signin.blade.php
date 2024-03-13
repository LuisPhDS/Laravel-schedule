<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cadastrar-se</title>
    {{-- Bootstrap link  CSS--}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- Font Awesome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- CSS link --}}
        <link rel="stylesheet" href="{{ asset('/assets/styles.css') }}">
        <link rel="stylesheet" href="{{ asset('/assets/css/signin.css') }}">
    {{-- Link favIcon --}}
        <link rel="shortcut icon" href="{{ asset('/assets/img/logo.svg') }}" type="image/x-icon">
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col text-center">
                <h2>Novo Usuário</h2>
            </div>


            <form action="{{ route('novo_usuario_submit') }}" method="post" class="col-6">
                @csrf

                {{-- Nome do Usuário --}}
                <div class="mb-3">
                    <label name="nome_usuario" class="form-label select">Nome:</label>
                    <div class="input-group">
                        <span class="input-group-text border-warning"><i class="fa-solid fa-signature"></i></span>
                        <input type="text" name="nome_usuario" id="nome_usuario" class="form-control border-warning" value="{{ old('nome_usuario') }}" placeholder="João José da Silva xavier">
                    </div>
                    @error('nome_usuario')
                        <div class="text-danger">{{ $errors->get('nome_usuario')[0] }}</div>
                    @enderror
                </div>
                {{-- E-mail do Usuário --}}
                <div class="mb-3">
                    <label name="email_usuario" class="form-label select">E-mail:</label>
                    <div class="input-group">
                        <span class="input-group-text border-warning"><i class="fa-solid fa-envelope"></i></span>
                        <input type="text" name="email_usuario" id="email_usuario" class="form-control border-warning" value="{{ old('email_usuario') }}" placeholder="jao.Silva@gmail.com">
                    </div>
                    @error('email_usuario')
                        <div class="text-danger">{{ $errors->get('email_usuario')[0] }}</div>
                    @enderror
                </div>

                {{-- Senha do Usuário --}}
                <div class="mb-3">
                    <label name="senha_usuario" class="form-label select">Senha:</label>
                    <div class="input-group">
                        <span class="input-group-text border-warning"><i class="fa-solid fa-key"></i></span>
                        <input type="password" name="senha_usuario" id="senha_usuario" class="form-control border-warning" value="{{ old('senha_usuario') }}" placeholder="deve conter no mínimo 6 caracteres">
                    </div>
                    @error('senha_usuario')
                        <div class="text-danger">{{ $errors->get('senha_usuario')[0] }}</div>
                    @enderror
                </div>


                {{-- cancel or submit --}}
                <div class="mb-3 d-flex text-center justify-content-between">
                    <a href="{{ route('index') }}" class="btn btn-secondary cancelar px-5 m-1"><i class="fa-regular fa-circle-xmark"></i> Cancelar</a>
                    <button type="submit" class="btn btn-secondary salvar px-5 m1"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
                </div>
            </form>

            
        </div>
        @if (session()->has('sucesso_usuario'))
                <div class="alert alert-success text-center p-1 erro-msg">
                    {{ session()->get('sucesso_usuario') }}
                </div>
        @endif
    </div>

    {{-- JS da mensagem --}}
    <script src="{{ asset('/assets/js/mensagem.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

    