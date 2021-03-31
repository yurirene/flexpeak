<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function redirect;
use function view;

class InventoryController extends Controller
{
    public function index()
    {
        $list = Inventory::paginate(5);
        return view("inventory.index", ["list"=>$list]);
    }

    public function create()
    {
        return view("inventory.create");
    }

    public function store(Request $request)
    {
        
        $item = new Inventory();
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
        
        return redirect()->route('inventory.index')->with($message);
        
    }
    
    public function edit($id)
    {
        $item = Inventory::find($id);
        if(!$item){
            $message = [
                "message" => "Item não Encontrado!",
                "type"=>"warning"
            ];
            return redirect()->route('inventory.index')->with($message);
        }
        
        return view("inventory.edit",["item"=>$item]);
    }

    public function update(Request $request, $id)
    {
        $item = Inventory::find($id);
        if(!$item){
            $message = [
                "message" => "Item não Encontrado!",
                "type"=>"warning"
            ];
            return redirect()->route('inventory.index')->with($message);
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
        
        return redirect()->route('inventory.index')
                ->with($message);
        
        
    }

    public function destroy(Request $request)
    {
        $item = Inventory::find($request->id);
        if(!$item){
            $message = [
                "message" => "Item não Encontrado!",
                "type"=>"warning"
            ];
            return redirect()->route('inventory.index')->with($message);
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
        return redirect()->route('inventory.index')->with($message);
    }
}
