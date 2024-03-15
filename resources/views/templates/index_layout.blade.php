<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    {{-- Bootstrap link  CSS--}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- Font Awesome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- CSS link --}}
        <link rel="stylesheet" href="{{ asset('/assets/styles.css') }}">
    {{-- Link favIcon --}}
        <link rel="shortcut icon" href="{{ asset('/assets/img/logo.svg') }}" type="image/x-icon">
    @yield('css')
</head>
<body class="d-flex flex-column min-vh-100">
    <header>
        <nav class="container p-3">
            <section class="row">
                <div class="col-2">
                    <a href="{{ route('index') }}">
                        <svg class="logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path fill="currentColor" d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192h80v56H48V192zm0 104h80v64H48V296zm128 0h96v64H176V296zm144 0h80v64H320V296zm80-48H320V192h80v56zm0 160v40c0 8.8-7.2 16-16 16H320V408h80zm-128 0v56H176V408h96zm-144 0v56H64c-8.8 0-16-7.2-16-16V408h80zM272 248H176V192h96v56z"/>
                        </svg>
                        {{-- <img src="{{ asset('/assets/img/logo.svg') }}" alt="Logo"> --}}
                    </a>
                </div>

                <div class="col-8">
                    <ul class="nav">
                        <li><a href="{{ route('index') }}">Tarefas</a></li>
                        <li><a href="{{ route('contatos') }}">Contatos</a></li>
                        <li><a href="{{-- {{ route('eventos') }} --}}">Eventos</a></li>
                    </ul>
                </div>
            
                <div class="col-2">
                    <span><i class="fa-regular fa-user"></i>{{--  Olá, {{ session()->get('nome') }}! --}}</span>
                    <span class="mx-3 opacity-50"><i class="fa-solid fa-ellipsis-vertical"></i></span>
                    <a href="{{ route('logout') }}" class="btn btn-outline-danger"><i class="fa-solid fa-power-off"></i> Sair</a>
                </div>
            </section>
        </nav>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer>
        <div class="footer">
            Saeb Schedule &copy; {{ date('Y') }}
        </div>
    </footer>

    {{-- Bootstrap link JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    {{-- JS da mensagem --}}
    <script src="{{ asset('/assets/js/mensagem.js') }}"></script>
    @yield('scripts')
</body>
</html>