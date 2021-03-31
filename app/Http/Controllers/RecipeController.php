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
        $list = Recipe::with("inventory")->orderBy("name")->paginate(5);
        return view("recipe.index", ["list"=>$list]);
    }

    public function create()
    {
        $fragrances = Inventory::where("is_fragrance", 1)->get();
        return view("recipe.create",["fragrances"=>$fragrances]);
    }

    public function store(Request $request)
    {
        
        $item = new Recipe();
        $item->name = $request->name;
        $item->per_water = $request->per_water;
        $item->per_alcohol = $request->per_alcohol;
        $item->per_fragrance = $request->per_fragrance;
        $item->fragrance_id = $request->fragrance;
        
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
        
        return redirect()->route('recipe.index')->with($message);
        
    }
    
    public function edit($id)
    {
        $recipe = Recipe::find($id);
        $fragrances = Inventory::where("is_fragrance", 1)->get();
        if(!$recipe){
            $message = [
                "message" => "Item não Encontrado!",
                "type"=>"warning"
            ];
            return redirect()->route('recipe.index')->with($message);
        }
        
        return view("recipe.edit",["recipe"=>$recipe, "fragrances"=>$fragrances]);
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
        $item->per_water = $request->per_water;
        $item->per_alcohol = $request->per_alcohol;
        $item->per_fragrance = $request->per_fragrance;
        $item->fragrance_id = $request->fragrance;
        
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
        
        return redirect()->route('recipe.index')
                ->with($message);
        
        
    }

    public function destroy(Request $request)
    {
        $item = Recipe::find($request->id);
        if(!$item){
            $message = [
                "message" => "Item não Encontrado!",
                "type"=>"warning"
            ];
            return redirect()->route('recipe.index')->with($message);
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
        return redirect()->route('recipe.index')->with($message);
    }
}
