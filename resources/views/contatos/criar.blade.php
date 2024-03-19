@extends('templates/index_layout')
@section('css')
    <link rel="stylesheet" href="{{ asset('/assets/css/contato.css') }}">
@endsection
@section('content')

    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <h4>Novo Contato</h4>
            </div>

            <form action="{{ route('novo_contato_submit') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-5 mt-5">
                        {{-- Nome do Contato --}}
                        <div class="mb-5">
                            <label for="contato_nome" class="form-label select">Nome:</label>
                            <div class="input-group">
                                <span class="input-group-text border-success"><i class="fa-solid fa-signature"></i></span>
                                <input type="text" name="contato_nome" id="contato_nome" class="form-control border-success" value="{{ old('contato_nome') }}" placeholder="João José da Silva xavier">
                            </div>
                            @error('contato_nome')
                                <div class="text-danger">{{ $errors->get('contato_nome')[0] }}</div>
                            @enderror
                        </div>
    
                        {{-- Telefone do Contato --}}
                        <div class="mb-5">
                            <label for="contato_tel" class="form-label select">Telefone:</label>
                            <div class="input-group">
                                <span class="input-group-text border-success"><i class="fa-solid fa-phone-volume"></i></span>
                                <input type="tel" name="contato_tel" id="contato_tel" class="form-control border-success" value="{{ old('contato_tel') }}" placeholder="(XX) X XXXX-XXXX">
                            </div>
                            @error('contato_tel')
                                <div class="text-danger">{{ $errors->get('contato_tel')[0] }}</div>
                            @enderror
                        </div>
    
                        {{-- Email do Contato --}}
                        <div class="mb-4">
                            <label for="contato_email" class="form-label select">E-mail:</label>
                            <div class="input-group">
                                <span class="input-group-text border-success"><i class="fa-regular fa-paper-plane"></i></span>
                                <input type="text" name="contato_email" id="contato_email" class="form-control border-success" value="{{ old('contato_email') }}" placeholder="XXX@XXXX.XXX">
                            </div>
                            @error('contato_email')
                                <div class="text-danger">{{ $errors->get('contato_email')[0] }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="text-center col-7 mb-3">
                        {{-- Imagem do Contato --}}
                        <div class="mb-3">
                            <div class="dropzone-box">
                                <h2>Anexe o arquivo</h2>
                                <p>Clique para fazer upload da imagem</p>
                                <div class="dropzone-area">
                                    <div class="file-upload-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                            <path fill="currentColor" d="M144 480C64.5 480 0 415.5 0 336c0-62.8 40.2-116.2 96.2-135.9c-.1-2.7-.2-5.4-.2-8.1c0-88.4 71.6-160 160-160c59.3 0 111 32.2 138.7 80.2C409.9 102 428.3 96 448 96c53 0 96 43 96 96c0 12.2-2.3 23.8-6.4 34.6C596 238.4 640 290.1 640 352c0 70.7-57.3 128-128 128H144zm79-217c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l39-39V392c0 13.3 10.7 24 24 24s24-10.7 24-24V257.9l39 39c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0l-80 80z"/>
                                        </svg>
                                    </div>
                                    <input 
                                        type="file"
                                        id="contato_imagem" name="contato_imagem"
                                        value="{{ old('contato_imagem') }}"
                                    >
                                    <p class="file-info">{{ old('contato_imagem') ? old('contato_imagem'): "Nenhum arquivo selecionado" }}</p>
                                </div>
                            </div>
                            @error('contato_imagem')
                                <div class="text-danger">{{ $errors->get('contato_imagem')[0] }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- cancel or submit --}}
                    <div class="col-12 ">
                        <div class="d-flex text-center mb-3 justify-content-between">
                            <a href="{{ route('contatos') }}" class="btn btn-secondary cancelar px-5 m-1"><i class="fa-regular fa-circle-xmark"></i> Cancelar</a>
                            <button type="submit" class="btn btn-secondary salvar px-5 m1"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
                        </div>
                    </div>
                </div>
            </form>            
        </div>
        @if (session()->has('error_contato'))
                <div class="alert alert-danger text-center erro-msg">
                    {{ session()->get('error_contato') }}
                </div>
        @endif
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('/assets/js/dragDropImg.js') }}"></script>
    <script>
        // Máscara telefone
        var telefoneContato = document.querySelector("#contato_tel");

        telefoneContato.addEventListener("input", ()=>{
            // remover os caracteres não numéricos
            var valorLimpo = telefoneContato.value.replace(/\D/g, "").substring(0,11);

             // dividir a string em um array
            var numerosArray = valorLimpo.split("");

            // variável do número formatado
            var numeroFormat = "";

            // condicional quando a quantidade de números for maior do que zero
            if(numerosArray.length > 0){
                numeroFormat += `(${numerosArray.slice(0,2).join("")})`;
            }

            // condicional quando a quantidade de números for maior do que dois
            if(numerosArray.length > 2){
                numeroFormat += ` ${numerosArray.slice(2,7).join("")}`;
            }

            // condicional quando a quantidade de números for maior do que sete
            if(numerosArray.length > 7){
                numeroFormat += `-${numerosArray.slice(7,11).join("")}`;
            }

            //  enviar o número formatado para o campo
            telefoneContato.value = numeroFormat;
        });

        telefoneContato.addEventListener("keydown", (event) => {
            if (event.key === "Backspace") {
                var valorLimpo = telefoneContato.value.replace(/\D/g, "").substring(0, 11);
                var numerosArray = valorLimpo.split("");
                var numeroFormat = "";
                
                // apaga o caracteres numéricos um a
                if (numerosArray.length > 0) {
                    numeroFormat += `${numerosArray.slice(0, 11).join("")}`;
                }

                telefoneContato.value = numeroFormat;
            }
        });
    </script>
@endsection