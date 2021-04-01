@extends('_template')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        Editar Item
    </div>
    <div class="card-body">
        <form action="{{route("inventory.update",["id"=>$item->id])}}" method="post">
            @csrf
            @method("PUT")
            <div class="form-group">
                <label for="name">Nome do Item</label>
                <input type="text" class="form-control" name="name" id="name" value="{{$item->name}}" required>
            </div>
            
            <div class="form-group">
                <label for="minimal_qty">Quantidade Mínima do Item</label>
                <div class="input-group">
                    <input type="text" class="form-control decimal" name="minimal_qty" id="minimal_qty" value="{{$item->minimal_qty}}" required>
                    <div class="input-group-append">
                        <div class="input-group-text">mL</div>
                    </div>
                </div>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="is_fragrance" name="is_fragrance" @if((int)$item->is_fragrance==1) {!! 'checked="checked" ' !!} @endif>
                <label class="form-check-label" for="is_fragrance">É uma Fragrância</label>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{route("inventory.index")}}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
    <div class="card-footer">
        <p class="text-muted">
            Criado em: {{$item->created_at}}
            <br>
            Atualizado em: {{$item->updated_at}}</p>
    </div>
</div>

@endsection