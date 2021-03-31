<?php

namespace App\Http\Controllers;

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
        $list = Operation::with(['operationType','inventory'])->get();
        
        return view("operation.index", ["list"=>$list]);
    }

    public function create()
    {
        $operatoion_types = OperationType::all();
        $items = Inventory::all();
        return view("operation.create",["$operatoion_types"=> $operatoion_types, "items"=>$items]);
    }

    public function store(Request $request)
    {
        
        $item = new Operation;
        $item->name = $request->name;
        $item->minimal_qty = $request->minimal_qty;
        $item->current_qty = 0;
        
        if($request->is_fragrance){
            $item->is_fragrance = 1;
        }
        
        if(!$item->save()){
            $message = [
                "message" => "Erro ao Registrar!",
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
        $item = Operation::find($id);
        if(!$item){
            $message = [
                "message" => "Item não Encontrado!",
                "type"=>"warning"
            ];
            return redirect()->route('operation.index')->with($message);
        }
        
        return view("operation.edit",["item"=>$item]);
    }

    public function update(Request $request, $id)
    {
        $item = Operation::find($id);
        if(!$item){
            $message = [
                "message" => "Item não Encontrado!",
                "type"=>"warning"
            ];
            return redirect()->route('operation.index')->with($message);
        }
        
        $item->minimal_qty = $request->minimal_qty;
        $item->name = $request->name;
        $item->is_fragrance = 0;
        if($request->is_fragrance){
            $item->is_fragrance = 1;
        }
        
        if(!$item->save()){
            $message = [
                "message" => "Erro ao Atualizar!",
                "type"=>"danger"
            ];
        }
        $message = [
            "message" => "Registro Atualizado com Sucesso!",
            "type"=>"success"
        ];
        
        return redirect()->route('operation.index')
                ->with($message);
        
        
    }

    public function destroy(Request $request)
    {
        $item = Operation::find($request->id);
        if(!$item){
            $message = [
                "message" => "Item não Encontrado!",
                "type"=>"warning"
            ];
            return redirect()->route('operation.index')->with($message);
        }
        
        if(!$item->delete()){
            $message = [
                "message" => "Erro ao Excluir Item!",
                "type" => "danger"
            ];
        }
        $message = [
            "message" => "Item Excluído!",
            "type"=>"success"
        ];
        return redirect()->route('operation.index')->with($message);
    }
}
