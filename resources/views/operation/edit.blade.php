@extends('_template')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        Editar Operação
    </div>
    <div class="card-body">
        <form action="{{route("operation.update",["id"=>$operation->id])}}" method="post">
            @csrf
            @method("PUT")
            <div class="form-group">
                <label for="operation_type">Tipo</label>
                <select class="form-control" id="operation_type" name="operation_type" required>
                    @foreach($operation_types as $type)
                    <option value="{{$type->id}}" 
                            @if((int)$operation->operation_type_id==(int)$type->id) {
                                {{'selected'}}
                            } @endif>
                            {{$type->name}}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="item">Item</label>
                <select class="form-control" id="item" name="item" required>
                    @foreach($items as $item)
                    <option value="{{$item->id}}" 
                            @if((int)$operation->inventory_id==(int)$item->id) {
                                {{'selected'}}
                            } @endif>
                            {{$item->name}}
                    </option>
                    @endforeach                    
                </select>
            </div>
            <div class="form-group">
                <label for="volume">Volume</label>
                <div class="input-group">
                    <input type="text" class="form-control decimal" name="volume" id="volume" value="{{$operation->volume}}" required>
                    <div class="input-group-append">
                        <div class="input-group-text">Litros</div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{route("operation.index")}}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
</div>

@endsection