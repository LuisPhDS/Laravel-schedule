@extends('templates/index_layout')
@section('css')
    <link rel="stylesheet" href="{{ asset('/assets/css/contato.css') }}">
@endsection
@section('content')
    <div class="container mb-3">
        <div class="row">
            <div class="col">
                <div class="row align-items-center">
                    <div class="col">
                        <h4>Contatos</h4>
                    </div>

                    <div class="col-6 text-center mb-5">
                        <form action="{{ route('filtro_contato')}}" method="post" id="filtroForm">
                            @csrf
                            <div class="mb-3 p-2"></div>
                            <div class="input-group">
                                <input type="text" class="form-control border-success" name="filtro" id="filtro" placeholder="Pesquisar...">
                                <button type="submit" class="input-group-text border-success"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </div>

                    <div class="col text-end">
                        <a href="{{ route('novo_contato') }}" class="btn btn-primary novo mb-3">
                            <i class="fa-solid fa-plus"></i> Novo Contato
                        </a>
                    </div>

                    @if (count($contatos) != 0)
                        <div class="row table-widget">
                            <div class="caption mb-3">
                                <button class="export-btn" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">{{-- <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--> --}}
                                        <path fill="currentColor" d="M246.6 9.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 109.3V320c0 17.7 14.3 32 32 32s32-14.3 32-32V109.3l73.4 73.4c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-128-128zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64c0 53 43 96 96 96H352c53 0 96-43 96-96V352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V352z"/>
                                    </svg>
                                    Exportar
                                </button>
                            </div>

                            <table>
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th class="text-center ">Telefone</th>
                                        <th class="text-center ">Email</th>
                                        <th class="text-center "><i class="fa-solid fa-sliders"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contatos as $contato)
                                        <tr>
                                            <td class="team-menber-profile">
                                                <img class="text-center" src="{!! $contato['contato_imagem'] !!}">
                                                <div class="profile-info">
                                                    <div class="profile-info_name">{!! $contato['contato_nome'] !!}</div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center telefone">
                                                    {!! $contato['contato_telefone'] !!}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center email">
                                                    {!! $contato['contato_email'] !!}        
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center tags">
                                                    <div class="tag">
                                                        {!! $contato['contato_acao'] !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modalDelecao{{ $contato['contato_id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content border-success">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5 text-truncate" id="exampleModalLabel"><strong>{!! $contato['contato_nome'] !!}</strong></h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Telefone: {!! $contato['contato_telefone'] !!}</strong></p>
                                                        <p><strong>E-mail: {!! $contato['contato_email'] !!}</strong></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                        <a href="{{ route('excluir_contato_confirmar', ['id' => Crypt::encrypt($contato['contato_id'])]) }}">
                                                            <button type="button" class="btn btn-outline-danger m-1">
                                                                Excluir
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center opacity-50 mb-10">Não existem contatos registrados</p>
                    @endif

                </div>
            </div>
        </div>
        @if(session()->has('sucesso_contato'))
            <div class="alert alert-success text-center erro-msg">
                {{ session()->get('sucesso_contato') }}
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            {{ $contatos_paginados->onEachSide(5)->links() }}
        </div>
    </div>

    
@endsection
@section('scripts')
    <script src="{{ asset('/assets/js/exportCsv.js') }}"></script>
@endsection