@extends('_template')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        Estoque
        <a href="{{route("inventory.create")}}" class="btn btn-primary">Adicionar Item</a>
    </div>
    <div class="card-body">
        <table class="table table-responsive-md table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Qtd. Atual</th>
                    <th scope="col">Qtd. Mínima</th>
                    <th scope="col" class="text-center">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($list as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item->current_qty}} mL</td>
                    <td>{{$item->minimal_qty}} mL</td>
                    <td  class="text-center">
                        <a href="{{route("inventory.edit", ["id"=>$item->id])}}" class="btn btn-warning">Editar</a>
                        <button href="#" class="btn btn-danger" 
                                data-toggle="modal" 
                                data-target="#delete" 
                                data-id='{{$item->id}}'>
                            Apagar
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$list->links()}}
    </div>
</div>

<div class="modal" tabindex="-1" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route("inventory.destroy")}}" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Ao fazer essa operação você estará apagando todos os 
                        registros de entrada e saída do inventário, Fórmulas e 
                        Registro de Produção que usem esse Item</p>
                </div>
                <input type="text" name="id" id="id" hidden="hidden">
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </div>
            </form>
            
        </div>
    </div>
</div>
@endsection
