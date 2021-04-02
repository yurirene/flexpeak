@extends('_template')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        Editar Registro de Produção
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <form action="{{route("production.update", ["id"=>$production->id])}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="recipe-production-edit">Fórmula</label>
                        <select class="form-control" id="recipe-production-edit" disabled>
                            <option value="{{$recipe->id}}"
                                    data-info='@json($recipe->components)' 
                                    selected >
                                {{$recipe->name}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="volume-production-edit">Volume</label>
                        <div class="input-group">
                            <input type="text" name="volume" 
                                   id="volume-production-edit" 
                                   class="form-control decimal" 
                                   value="{{$production->volume}}">
                            <div class="input-group-append">
                                <div class="input-group-text">mL</div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Atualizar</button>
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