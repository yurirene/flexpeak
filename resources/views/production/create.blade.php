@extends('_template')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        Novo Registro de Produção
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <form action="{{route("production.store")}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="recipe-production">Fórmula</label>
                        <select class="form-control" id="recipe-production" name="recipe" required>
                            @foreach($recipes as $recipe)
                            <option value="{{$recipe->id}}"
                                    data-info='@json($recipe->components)'>
                                {{$recipe->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="volume-production">Volume</label>
                        <div class="input-group">
                            <input type="text" name="volume" id="volume-production" class="form-control decimal" required>
                            <div class="input-group-append">
                                <div class="input-group-text">mL</div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    <a href="{{route("production.index")}}" class="btn btn-secondary">Voltar</a>
                </form>
            </div>
            <div class="col">
                <h4 class="text-muted">Ingredientes:</h4>
                <table class="table">
                    <thead>
                        <th>Nome</th>
                        <th>Necessário</th>
                        <th>Disponível</th>
                    </thead>
                    <tbody id="ingredients-show">
                        
                    </tbody>
                </table>
            </div>
        </div>
        
        
    </div>
</div>

@endsection