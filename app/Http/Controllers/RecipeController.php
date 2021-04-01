<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Recipe;
use Illuminate\Http\Request;
use function redirect;
use function view;

class RecipeController extends Controller
{
    public function index()
    {
        $list = Recipe::with("components")->paginate(5);
        
        return view("recipe.index", ["list"=>$list]);
    }

    public function create()
    {
        $inventories = Inventory::get();
        return view("recipe.create",["inventories"=>$inventories]);
    }

    public function store(Request $request)
    {
        
        $recipe = new Recipe();
        $recipe->name = $request->name;
        
        $parameters = array();
        
        foreach($request->ingredients['id'] as $k => $v){
            $parameters[$v] = [
                "percent"=>$request->ingredients['percent'][$k]
            ];
        }
        
        
        if(!$recipe->verifyPercent($request->ingredients['percent'])){
            $message = [
                "message" => "Os percentuais não totalizam 100%",
                "type"=>"warning"
            ];
            return redirect()->route('recipe.create')->with($message);
        }
        
        if(!$recipe->save()){
            $message = [
                "message" => "Erro ao Registrar!",
                "type"=>"danger"
            ];
        }
        $recipe->components()->sync($parameters);
        
        $message = [
            "message" => "Registro Inserido com Sucesso!",
            "type"=>"success"
        ];
        return redirect()->route('recipe.index')->with($message);
        
    }
    
    public function edit($id)
    {
        $recipe = Recipe::with("components")->find($id);
        $inventories = Inventory::get();
        if(!$recipe){
            $message = [
                "message" => "Item não Encontrado!",
                "type"=>"warning"
            ];
            return redirect()->route('recipe.index')->with($message);
        }
        
        return view("recipe.edit",[
            "recipe"=>$recipe, 
            "inventories"=>$inventories
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Recipe::find($id);
                
        if(!$item){
            $message = [
                "message" => "Item não Encontrado!",
                "type"=>"warning"
            ];
            return redirect()->route('recipe.index')->with($message);
        }
        
        $item->name = $request->name;
        
        
        $parameters = array();
        
        foreach($request->ingredients['id'] as $k => $v){
            $parameters[$v] = [
                "percent"=>$request->ingredients['percent'][$k]
            ];
        }
        
        
        if(!$item->verifyPercent($request->ingredients['percent'])){
            $message = [
                "message" => "Os percentuais não totalizam 100%",
                "type"=>"warning"
            ];
            return redirect()->route('recipe.edit',["id"=>$id])->with($message);
        }
        
        if(!$item->save()){
            $message = [
                "message" => "Erro ao Atualizar!",
                "type"=>"danger"
            ];
        }
        
        
        $item->components()->sync($parameters);
        
        $message = [
            "message" => "Registro Atualizado com Sucesso!",
            "type"=>"success"
        ];
        
        return redirect()->route('recipe.index')
                ->with($message);
        
        
    }

    public function destroy(Request $request)
    {
        $item = Recipe::find($request->id);
        if(!$item){
            $message = [
                "message" => "Registro não Encontrado!",
                "type"=>"warning"
            ];
            return redirect()->route('recipe.index')->with($message);
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
        return redirect()->route('recipe.index')->with($message);
    }
}
