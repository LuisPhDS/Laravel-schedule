@extends('templates/index_layout')
@section('content')

    <div class="container mb-3">
        <div class="row">
            <div class="col">
                <div class="row align-items-center">
                    <div class="col">
                        <h4>Tarefas</h4>
                    </div>

                    <div class="col-6 text-center mb-5">
                        <form action="{{ route('filtro', ['filtro' => 'all']) }}" method="post" id="filtroForm">
                            @csrf
                            <label for="filtro" class="form-label select">Prioridade:</label>
                            <select name="filtro" id="filtro" class="form-control border-success" onchange="submitForm(event)">
                                <option value="{{ 'all' }}" {{ (!empty($filtro) && $filtro == 'all') ? 'selected' : '' }}>
                                    Todos
                                </option>
                                <option value="{{ 1 }}" {{ (!empty($filtro) && $filtro == '1') ? 'selected' : '' }}>
                                    Emergencial
                                </option>
                                <option value="{{ 2 }}" {{ (!empty($filtro) && $filtro == '2') ? 'selected' : '' }}>
                                    Alta
                                </option>
                                <option value="{{ 3 }}" {{ (!empty($filtro) && $filtro == '3') ? 'selected' : '' }}>
                                    Média
                                </option>
                                <option value="{{ 4 }}" {{ (!empty($filtro) && $filtro == '4') ? 'selected' : '' }}>
                                    Baixa
                                </option>
                            </select>
                        </form>
                    </div>

                    <div class="col text-end">
                        <a href="{{ route('nova_tarefa') }}" class="btn btn-primary novo mb-3">
                            <i class="fa-solid fa-plus"></i> Nova Tarefa
                        </a>
                    </div>

                    @if (count($tarefas) != 0)
                        <div class="row">
                            @foreach($tarefas as $tarefa)
                                <div class="col-4 mt-5 ml-5 card border-success">
                                    <div class="card-header d-flex justify-content-between">
                                        {!! $tarefa['tarefa_titulo'] !!}
                                        <p class="card-text">{!! $tarefa['tarefa_prioridade'] !!}</p>
                                    </div>
                                    <div class="card-body text-primary">
                                        <h5 class="card-title text-truncate">{!! $tarefa['tarefa_descricao'] !!}</h5>
                                        <div class="d-flex justify-content-evenly">{!! $tarefa['tarefa_acao'] !!}</div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="modalDelecao{{ $tarefa['tarefa_id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content border-success">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">{!! $tarefa['tarefa_titulo'] !!}</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {!! $tarefa['tarefa_descricao'] !!}
                                                <p>Prioridade: {!! $tarefa['tarefa_prioridade'] !!}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                <a href="{{ route('excluir_tarefa_confirmar', ['id' => Crypt::encrypt($tarefa['tarefa_id'])]) }}">
                                                    <button type="button" class="btn btn-outline-danger m-1">
                                                        Excluir
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                        </div>
                    @else
                        <p class="text-center opacity-50 mb-10">Não existem tarefas registradas</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
            
            
@endsection

@section('scripts')
    <script>
        function submitForm(event) {
            event.preventDefault();

            let filtroValue = document.getElementById("filtro").value;
            document.getElementById("filtroForm").action = "{{ url('/filtro/') }}" + '/' + filtroValue;

            console.log("Enviando formulário...");
            document.getElementById("filtroForm").submit();
        }
    </script>
@endsection