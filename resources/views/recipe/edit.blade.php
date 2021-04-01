@extends('_template')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        Editar Fórmula
    </div>
    <div class="card-body">
        <form action="{{route("recipe.update",["id"=>$recipe->id])}}" method="post">
            @csrf
            @method("PUT")
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{$recipe->name}}">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="fragrance">Fragrância</label>
                        <select class="form-control" id="fragrance" name="fragrance" required>
                            <option selected disabled>Selecione a Fragrância</option>
                            @foreach($fragrances as $fragrance)
                            <option value="{{$fragrance->id}}" 
                                    @if((int)$fragrance->id==(int)$recipe->fragrance_id) {
                                        {{'selected'}}
                                    } @endif>
                                    {{$fragrance->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="per_water">Porcentagem de Água</label>
                        <div class="input-group">
                            <input type="text" class="form-control percent" 
                                   name="per_water" id="per_water" 
                                   value="{{$recipe->per_water}}" required>
                            <div class="input-group-append">
                                <div class="input-group-text">%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="per_alcohol">Porcentagem de Álcool</label>
                        <div class="input-group">
                            <input type="text" class="form-control percent" 
                                   name="per_alcohol" id="per_alcohol" 
                                   value="{{$recipe->per_alcohol}}" required>
                            <div class="input-group-append">
                                <div class="input-group-text">%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="per_fragrance">Porcentagem de Fragrância</label>
                        <div class="input-group">
                            <input type="text" class="form-control percent" 
                                   name="per_fragrance" id="per_fragrance" 
                                   value="{{$recipe->per_fragrance}}" required>
                            <div class="input-group-append">
                                <div class="input-group-text">%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col"></div>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{route("recipe.index")}}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
    <div class="card-footer">
        <p class="text-muted">
            Criado em: {{$recipe->created_at}}
            <br>
            Atualizado em: {{$recipe->updated_at}}</p>
    </div>
</div>

@endsection