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
</head>
<body class="d-flex flex-column min-vh-100">
    <header class="linha">
        <nav class="container p-3">
            <section class="row">
                <div class="col-2">
                    <a href="/">
                        <img src="{{ asset('/assets/img/logo.svg') }}" alt="Logo">
                    </a>
                </div>

                <div class="col-8">
                    <ul class="nav">
                        <li><a href="{{ route('index') }}">Tarefas</a></li>
                        <li><a href="{{-- {{ route('contatos') }} --}}">Contatos</a></li>
                        <li><a href="{{-- {{ route('eventos') }} --}}">Eventos</a></li>
                    </ul>
                </div>
            
                <div class="col-2">
                    <span><i class="fa-regular fa-user"></i>{{-- {{ session()->get('username') }} --}}</span>
                    <span class="mx-3 opacity-50"><i class="fa-solid fa-ellipsis-vertical"></i></span>
                    <a href="{{ route('logout') }}" class="btn btn-outline-danger"><i class="fa-solid fa-power-off"></i> Sair</a>
                </div>
            </section>
        </nav>
    </header>

    <main class="container linha">
        @yield('content')
    </main>

    <footer class="linha">
        <div class="footer linha">
            Saeb Schedule &copy; {{ date('Y') }}
        </div>
    </footer>

    {{-- Bootstrap link JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>