@extends('templates/index_layout')
@section('content')

    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <h4>Nova Tarefa</h4>
            </div>


            <form action="{{ route('nova_tarefa_submit') }}" method="post">
                @csrf

                {{-- Título da tarefa --}}
                <div class="mb-3">
                    <label name="titulo_tarefa" class="form-label">Nome:</label>
                    <input type="text" name="titulo_tarefa" id="titulo_tarefa" class="form-control border-success" value="{{ old('titulo_tarefa') }}">
                    @error('titulo_tarefa')
                        <div class="text-danger">{{ $errors->get('titulo_tarefa')[0] }}</div>
                    @enderror
                </div>

                {{-- Descrição da tarefa --}}
                <div class="mb-3">
                    <label name="descricao_tarefa" class="form-label">Descrição:</label>
                    <textarea name="descricao_tarefa" id="descricao_tarefa" cols="30" rows="5" class="form-control border-success">{{ old('descricao_tarefa') }}</textarea>
                    @error('descricao_tarefa')
                        <div class="text-danger">{{ $errors->get('descricao_tarefa')[0] }}</div>
                    @enderror
                </div>

                <div class="mb-5 row">
                    <div class="col-4">
                        <label for="data_termino_tarefa" class="form-label">Data limite:</label>
                        <input type="date" name="data_termino_tarefa" id="data_termino_tarefa" class="form-control border-success">
                        @error('data_termino_tarefa')
                            <div class="text-danger">{{ $errors->get('descricao_tarefa')[0] }}</div>
                        @enderror
                    </div>

                    <span class="col-2"></span>

                    <div class="col-6">
                        <label for="prioridade_tarefa" class="form-label">Prioridade:</label>
                        <select name="prioridade_tarefa" id="prioridade_tarefa" class="form-select border-success">
                            <option value="-1">--</option>
                            <option value="1">Emergencial</option>
                            <option value="2">Alta</option>
                            <option value="3">Média</option>
                            <option value="4">Baixa</option>
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