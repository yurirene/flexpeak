@extends('_template')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        Novo Registro de Produção
    </div>
    <div class="card-body">
        <form action="{{route("production.store")}}" method="post">
            @csrf
            <div class="form-group">
                <label for="recipe">Fórmula</label>
                <select class="form-control" id="recipe" name="recipe" required>
                    <option selected disabled>Selecione a Receitas</option>
                    @foreach($recipes as $recipe)
                    <option value="{{$recipe->id}}">{{$recipe->name}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="volume">Volume</label>
                <input type="text" name="volume" id="volume" class="form-control">
            </div>
            
            <button type="submit" class="btn btn-primary">Cadastrar</button>
            <a href="{{route("production.index")}}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
</div>

@endsection