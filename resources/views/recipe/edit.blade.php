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
            
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" class="form-control" value="{{$recipe->name}}">
            </div>
            @foreach($recipe->components as $component)
            <div class="row" id="inputFormRow">
                <div class="col">
                    <div class="form-group">
                        <label for="ingredients[id][]">Ingrediente</label>
                        <select class="form-control" id="ingrediente[id][]" name="ingredients[id][]" required>
                            <option selected disabled>Selecione um Ingrediente</option>
                            @foreach($inventories as $inventory)
                            <option value="{{$inventory->id}}"
                                @if((int)$inventory->id == (int)$component->pivot->inventory_id)
                                    {{'selected'}}
                                @endif
                                >
                                {{$inventory->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="ingredients[percent][]">Porcentagem</label>
                        <div class="input-group">
                            <input type="text" class="form-control decimal" 
                                   name="ingredients[percent][]" 
                                   id="ingredients[percent][]" value="{{$component->pivot->percent}}" required>
                            <div class="input-group-append">
                                <div class="input-group-text">%</div>
                                <button id="removeRow" type="button" class="btn btn-danger">Remover</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
            <div id="newRow"></div>
            <button type="button" class="btn btn-secondary float-right" id="addRow">Adicionar Ingrediente</button>
            
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{route("recipe.index")}}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
    <div class="card-footer">
        <p class="text-muted">
            Criado em: {{date("d/m/y H:i:s", strtotime($recipe->created_at))}}
            <br>
            Atualizado em: {{date("d/m/y H:i:s", strtotime($recipe->updated_at))}}</p>
    </div>
</div>

@endsection


@section('script')
<script>
$("#addRow").click(function () {
    var html = '';
    html += "<div class='row' id='inputFormRow'>";
    html += "<div class='col'>";
    html += "<div class='form-group'>";
    html += "<label for='ingredients[id][]'>Ingrediente</label>";
    html += "<select class='form-control' id='ingredients[id][]' name='ingredients[id][]' required>";
    @foreach($inventories as $inventory)
    html += "<option value='{{$inventory->id}}'>{{$inventory->name}}</option>";
    @endforeach
    html += "</select>";
    html += "</div>";
    html += "</div>";
    html += "<div class='col'>";
    html += "<div class='form-group'>";
    html += "<label for='ingredients[percent][]'>Porcentagem</label>";
    html += "<div class='input-group'>";
    html += "<input type='text' class='form-control decimal' name='ingredients[percent][]' id='ingredients[percent][]' required>";
    html += "<div class='input-group-append'>";
    html += "<div class='input-group-text'>%</div>";
    html += '<button id="removeRow" type="button" class="btn btn-danger">Remover</button>';
    html += "</div>";
    html += "</div>";
    html += "</div>";
    html += "</div>";
    html += "</div>";

    $('#newRow').append(html);
});
</script>
@endsection