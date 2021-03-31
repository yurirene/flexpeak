<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateOperationRequest;
use App\Models\Inventory;
use App\Models\Operation;
use App\Models\OperationType;
use Illuminate\Http\Request;
use function redirect;
use function view;

class OperationController extends Controller
{
    public function index()
    {
        $list = Operation::with(['operationType','inventory'])->latest()->paginate(5);
        
        return view("operation.index", ["list"=>$list]);
    }

    public function create()
    {
        $operation_types = OperationType::all();
        $items = Inventory::all();
        return view("operation.create",[
            "operation_types"=> $operation_types, 
            "items"=>$items
        ]);
    }

    public function store(StoreUpdateOperationRequest $request)
    {
        
        $operation = new Operation();
        $operation->inventory_id = $request->item;
        $operation->operation_type_id = $request->operation_type;
        $operation->volume = $request->volume;
        
        if(!$operation->haveStock()){
            
            $message = [
                "message" => "Você não tem Estoque para Fazer esse Lançamento!",
                "type"=>"danger"
            ];
            return redirect()->route('operation.create')->with($message);
        }
        
        if(!$operation->save()){
            $message = [
                "message" => "Erro ao Registrar!",
                "type"=>"danger"
            ];
        }
        $inventory = (new Inventory())->updateStock($operation);
        if(!$inventory){
            $operation->delete();
            $message = [
                "message" => "Erro ao Atualizar o Estoque. Tente Novamente!",
                "type"=>"danger"
            ];
        }
        $message = [
            "message" => "Registro Inserido com Sucesso!",
            "type"=>"success"
        ];
        
        return redirect()->route('operation.index')->with($message);
        
    }
    
    public function edit($id)
    {
        $operation = Operation::find($id);
        if(!$operation){
            $message = [
                "message" => "Registro Inválido!",
                "type"=>"warning"
            ];
            return redirect()->route('operation.index')->with($message);
        }
        $operation_types = OperationType::all();
        $items = Inventory::all();
        return view("operation.edit",[
            "operation"=>$operation,
            "operation_types"=> $operation_types, 
            "items"=>$items
        ]);
    }

    public function update(StoreUpdateOperationRequest $request, $id)
    {
        $operation = Operation::find($id);
        if(!$operation){
            $message = [
                "message" => "Registro Inválido!",
                "type"=>"warning"
            ];
            return redirect()->route('operation.index')->with($message);
        }
        
        $obj = array(
            "type"=>$operation->operation_type_id,
            "volume"=>$operation->volume
        );
        
        $operation->inventory_id = $request->item;
        $operation->operation_type_id = $request->operation_type;
        $operation->volume = $request->volume;
        
        if(!$operation->haveStock($obj)){
            
            $message = [
                "message" => "Você não tem Estoque para Fazer essa Edição!",
                "type"=>"danger"
            ];
            return redirect()->route('operation.edit')->with($message);
        }
        
        if(!$operation->save()){
            $message = [
                "message" => "Erro ao Atualizar Registro!",
                "type"=>"danger"
            ];
        }
        
        $inventory = (new Inventory())->updateStock($operation,$obj);
        if(!$inventory){
            $operation->operation_type_id = $obj['type'];
            $operation->volume = $obj['volume'];
            $operation->save();
        }
        $message = [
            "message" => "Registro Atualizado com Sucesso!",
            "type"=>"success"
        ];
        
        return redirect()->route('operation.index')->with($message);
        
        
    }

    public function destroy(Request $request)
    {
        $operation = Operation::find($request->id);
        if(!$operation){
            $message = [
                "message" => "Registro Inválido!",
                "type"=>"warning"
            ];
            return redirect()->route('operation.index')->with($message);
        }
        
        $obj = array(
            "type"=>$operation->operation_type_id,
            "volume"=>$operation->volume
        );
        
        
        $inventory = (new Inventory())->updateStockOnDelete($operation,$obj);
        
        if(!$inventory){
            $message = [
                "message" => "Erro ao Atualizar o Estoque!",
                "type"=>"danger"
            ];
            return redirect()->route('operation.index')->with($message);
        }
        
        if(!$operation->delete()){
            $message = [
                "message" => "Erro ao Excluir Registro!",
                "type" => "danger"
            ];
        }
        
        
        $message = [
            "message" => "Registro Excluído!",
            "type"=>"success"
        ];
        return redirect()->route('operation.index')->with($message);
    }
}
