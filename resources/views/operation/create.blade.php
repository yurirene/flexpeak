@extends('_template')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        Nova Operação
    </div>
    <div class="card-body">
        <form action="{{route("operation.store")}}" method="post">
            @csrf
            <div class="form-group">
                <label for="operation_type">Tipo</label>
                <select class="form-control" id="operation_type" name="operation_type" required>
                    <option selected disabled>Selecione um tipo</option>
                    @foreach($operation_types as $type)
                    <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="item">Item</label>
                <select class="form-control" id="item" name="item" required>
                    <option selected disabled>Selecione um Item</option>
                    @foreach($items as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach                    
                </select>
            </div>
            <div class="form-group">
                <label for="volume">Volume</label>
                <div class="input-group">
                    <input type="text" class="form-control decimal" name="volume" id="volume" required>
                    <div class="input-group-append">
                        <div class="input-group-text">mL</div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
            <a href="{{route("operation.index")}}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
</div>

@endsection