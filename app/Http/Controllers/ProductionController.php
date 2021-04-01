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
        $recipes = Recipe::get();
        return view("production.create",["recipes"=>$recipes]);
    }

    public function store(Request $request)
    {
        
        $item = new Production();
        $item->recipe_id = $request->recipe;
        $item->volume = $request->volume;
        
        
        
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
        
        $item->recipe_id = $request->recipe;
        $item->volume = $request->volume;
        
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
        
        if(!$item->delete()){
            $message = [
                "message" => "Erro ao Excluir Registro!",
                "type" => "danger"
            ];
        }
        $message = [
            "message" => "Registro Excluído!",
            "type"=>"success"
        ];
        return redirect()->route('production.index')->with($message);
    }
}
