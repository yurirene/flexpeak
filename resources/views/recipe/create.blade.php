@extends('_template')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        Nova Fórmula
    </div>
    <div class="card-body">
        <form action="{{route("recipe.store")}}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="ingredients[id][]">Ingrediente</label>
                        <select class="form-control" id="ingrediente[id][]" name="ingredients[id][]" required>
                            <option selected disabled>Selecione um Ingrediente</option>
                            @foreach($inventories as $inventory)
                            <option value="{{$inventory->id}}">{{$inventory->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="ingredients[percent][]">Porcentagem</label>
                        <div class="input-group">
                            <input type="text" class="form-control decimal" name="ingredients[percent][]" id="ingredients[percent][]" required>
                            <div class="input-group-append">
                                <div class="input-group-text">%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="newRow"></div>
            <button type="button" class="btn btn-secondary float-right" id="addRow">Adicionar Ingrediente</button>
            
            
            <button type="submit" class="btn btn-primary">Cadastrar</button>
            <a href="{{route("recipe.index")}}" class="btn btn-secondary">Voltar</a>
        </form>
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
    html += "<option selected disabled>Selecione um Ingrediente</option>";
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