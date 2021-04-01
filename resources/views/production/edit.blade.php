@extends('_template')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        Editar Registro de Produção
    </div>
    <div class="card-body">
        <form action="{{route("production.update",["id"=>$production->id])}}" method="post">
            @csrf
            @method("PUT")
            <div class="form-group">
                <label for="recipe">Receita</label>
                <select class="form-control" id="recipe" name="recipe" required>
                    @foreach($recipes as $recipe)
                    <option value="{{$recipe->id}}" 
                            @if((int)$recipe->id==(int)$production->recipe_id) {
                        {{'selected'}}
                        } @endif>
                        {{$recipe->name}}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="volume">Volume</label>
                <input type="text" name="volume" id="volume" class="form-control decimal" value="{{$production->volume}}">
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{route("production.index")}}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
</div>

@endsection