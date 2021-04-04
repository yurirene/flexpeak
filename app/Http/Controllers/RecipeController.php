<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRequest;
use App\Http\Requests\StoreUpdateRecipeRequest;
use App\Models\Inventory;
use App\Models\Recipe;
use App\Services\RecipeService;
use Illuminate\Http\Request;
use function redirect;
use function view;

class RecipeController extends Controller
{
    
    protected $service;
    
    public function __construct(RecipeService $service) {
        $this->service = $service;
    }
    
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

    public function store(StoreUpdateRecipeRequest $request)
    {
        $return = $this->service->store($request->all());
        
        $message = [
            "message" => $return["message"],
            "type"=> $return["type"]
        ];
        return redirect()->route($return["route"])->with($message);
        
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

    public function update(StoreUpdateRecipeRequest $request, $id)
    {
        $return = $this->service->update($request->all(), $id);
        
        $message = [
            "message" => $return["message"],
            "type"=> $return["type"]
        ];
        
        return redirect()->route($return["route"])->with($message);
    }

    public function destroy(DeleteRequest $request)
    {
       $return = $this->service->destroy($request->id);
        
        $message = [
            "message" => $return["message"],
            "type"=> $return["type"]
        ];
        
        return redirect()->route($return["route"])->with($message);
    }
}
