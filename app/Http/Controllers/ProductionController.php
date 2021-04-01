<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Production;
use App\Models\Recipe;
use Illuminate\Http\Request;
use function redirect;
use function view;

class ProductionController extends Controller
{
    public function index()
    {
        $list = Production::with("recipe")->paginate(5);
        
        return view("production.index", ["list"=>$list]);
    }

    public function create()
    {
        $recipes = Recipe::with("components")->get();
        return view("production.create",["recipes"=>$recipes]);
    }

    public function store(Request $request)
    {
        
        $item = new Production();
        $item->recipe_id = $request->recipe;
        $item->volume = $request->volume;
        
        if(!$item->haveStock()){
            $message = [
                "message" => "Sem estoque suficiente para produzir essa quantidade!",
                "type"=>"danger"
            ];
            return redirect()->route('production.create')->with($message);
        }
        
        if(!$item->save()){
            $message = [
                "message" => "Erro ao Registrar!",
                "type"=>"danger"
            ];
        }
        
        $item->updateStock();
        
        $message = [
            "message" => "Registro Inserido com Sucesso!",
            "type"=>"success"
        ];
        return redirect()->route('production.index')->with($message);
        
    }
    
    public function edit($id)
    {
        $production = Production::find($id);
        $recipes = Recipe::get();
        if(!$production){
            $message = [
                "message" => "Item não Encontrado!",
                "type"=>"warning"
            ];
            return redirect()->route('production.index')->with($message);
        }
        
        return view("production.edit",["production"=>$production, "recipes"=>$recipes]);
    }

    public function update(Request $request, $id)
    {
        $item = Production::find($id);
        if(!$item){
            $message = [
                "message" => "Item não Encontrado!",
                "type"=>"warning"
            ];
            return redirect()->route('production.index')->with($message);
        }
        $reverse = array(
            "type"=>2,
            "volume"=>$item->volume
        );
        $item->recipe_id = $request->recipe;
        $item->volume = $request->volume;
        
        if(!$item->haveStock()){
            $message = [
                "message" => "Sem estoque suficiente para produzir essa quantidade!",
                "type"=>"danger"
            ];
            return redirect()->route('production.create')->with($message);
        }
        
        if(!$item->save()){
            $message = [
                "message" => "Erro ao Atualizar!",
                "type"=>"danger"
            ];
        }
        $item->updateStock($reverse);
        
        $message = [
            "message" => "Registro Atualizado com Sucesso!",
            "type"=>"success"
        ];
        
        return redirect()->route('production.index')->with($message);
        
        
    }

    public function destroy(Request $request)
    {
        $item = Production::find($request->id);
        if(!$item){
            $message = [
                "message" => "Registro não Encontrado!",
                "type"=>"warning"
            ];
            return redirect()->route('production.index')->with($message);
        }
        
        $reverse = array(
            "type"=>2,
            "volume"=>$item->volume
        );
        
        if(!$item->delete()){
            $message = [
                "message" => "Erro ao Excluir Registro!",
                "type" => "danger"
            ];
        }
        //$item->deleteAndUpdateStock($reverse);
        
        $message = [
            "message" => "Registro Excluído!",
            "type"=>"success"
        ];
        return redirect()->route('production.index')->with($message);
    }
}
