@extends('templates/index_layout')
@section('content')

    <div class="container">

        @if (session()->has('error_tarefa'))
                <div class="alert alert-danger text-center p-1 erro-msg">
                    {{ session()->get('error_tarefa') }}
                </div>
            @endif

        <div class="row mt-5">
            <div class="col">
                <h4>Editar Tarefa</h4>
            </div>


            <form action="{{ route('editar_tarefa_subimit') }}" method="post">
                @csrf

                {{-- Id da tarefa --}}
                <input type="hidden" name="id_tarefa" value="{{ Crypt::encrypt($tarefa->id) }}">

                {{-- Título da tarefa --}}
                <div class="mb-3">
                    <label name="titulo_tarefa" class="form-label select">Nome:</label>
                    <input type="text" name="titulo_tarefa" id="titulo_tarefa" class="form-control border-success" value="{{ old('titulo_tarefa', $tarefa->titulo) }}">
                    @error('titulo_tarefa')
                        <div class="text-danger">{{ $errors->get('titulo_tarefa')[0] }}</div>
                    @enderror
                </div>

                {{-- Descrição da tarefa --}}
                <div class="mb-3">
                    <label name="descricao_tarefa" class="form-label select">Descrição:</label>
                    <textarea name="descricao_tarefa" id="descricao_tarefa" cols="30" rows="5" class="form-control border-success">{{ old('descricao_tarefa', $tarefa->descricao) }}</textarea>
                    @error('descricao_tarefa')
                        <div class="text-danger">{{ $errors->get('descricao_tarefa')[0] }}</div>
                    @enderror
                </div>

                <div class="mb-5 row">
                    {{-- Data limite da tarefa --}}
                    <div class="col-4">
                        <label for="data_termino_tarefa" class="form-label select">Data limite:</label>
                        <input type="date" name="data_termino_tarefa" id="data_termino_tarefa" class="form-control border-success" value="{{ old('data_termino_tarefa', $tarefa->data_termino) }}">
                        @error('data_termino_tarefa')
                            <div class="text-danger">{{ $errors->get('descricao_tarefa')[0] }}</div>
                        @enderror
                    </div>

                    <span class="col-2"></span>
                    {{-- Prioridade da tarefa --}}
                    <div class="col-6">
                        <label for="prioridade_tarefa" class="form-label select">Prioridade:</label>
                        <select name="prioridade_tarefa" id="prioridade_tarefa" class="form-select border-success">
                            <option value="1" {{ old('prioridade_tarfa', $tarefa->prioridade == 1 ? "selected" : "") }}>Emergencial</option>
                            <option value="2" {{ old('prioridade_tarfa', $tarefa->prioridade == 2 ? "selected" : "") }}>Alta</option>
                            <option value="3" {{ old('prioridade_tarfa', $tarefa->prioridade == 3 ? "selected" : "") }}>Média</option>
                            <option value="4" {{ old('prioridade_tarfa', $tarefa->prioridade == 4 ? "selected" : "") }}>Baixa</option>
                        </select>
                        @error('prioridade_tarefa')
                            <div class="text-danger">{{ $errors->get('descricao_tarefa')[0] }}</div>
                        @enderror
                    </div>
                </div>

                {{-- cancel or submit --}}
                <div class="mb-3 d-flex text-center justify-content-between">
                    <a href="{{ route('index') }}" class="btn btn-secondary cancelar px-5 m-1"><i class="fa-regular fa-circle-xmark"></i> Cancelar</a>
                    <button type="submit" class="btn btn-secondary salvar px-5 m1"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
                </div>
            </form>
            

        </div>
    </div>

@endsection