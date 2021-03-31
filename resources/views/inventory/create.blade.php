@extends('_template')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        Novo Item
    </div>
    <div class="card-body">
        <form action="{{route("inventory.store")}}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Nome do Item</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            
            <div class="form-group">
                <label for="minimal_qty">Quantidade Mínima do Item</label>
                <div class="input-group">
                    
                    <input type="text" class="form-control decimal" name="minimal_qty" id="minimal_qty" required>
                    <div class="input-group-append">
                        <div class="input-group-text">Litros</div>
                    </div>
                </div>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="is_fragrance" name="is_fragrance">
                <label class="form-check-label" for="is_fragrance">É uma Fragrância</label>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
            <a href="{{route("inventory.index")}}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
</div>

@endsection