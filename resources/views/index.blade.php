@extends('templates/index_layout')
@section('content')

    <div class="container mb-3">
        <div class="row">
            <div class="col">
                <div class="row align-items-center">
                    <div class="col">
                        <h4>Tarefas</h4>
                    </div>

                    <div class="col text-end">
                        <a href="#" class="btn btn-primary mb-3">
                            <i class="fa-solid fa-square-plus"></i> Nova Tarefa
                        </a>
                    </div>

                    @if (count($tarefas) != 0)
                        <div class="container d-flex">
                            @foreach($tarefas as $tarefa)
                                <div class="card border-primary mb-3 d-flex" style="max-width: 18rem;">
                                    <div class="card-header d-flex justify-content-between">
                                        {!! $tarefa['tarefa_titulo'] !!}
                                        <span class="text-end"><small>Nova</small></span>
                                    </div>
                                    <div class="card-body text-primary">
                                        <h5 class="card-title">{!! $tarefa['tarefa_descricao'] !!}</h5>
                                        <p class="card-text">{!! $tarefa['tarefa_status'] !!}</p>
                                        <div class="d-flex justify-content-evenly">{!! $tarefa['tarefa_acao'] !!}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center opacity-50 my-5">Não existem tarefas registradas</p>
                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection