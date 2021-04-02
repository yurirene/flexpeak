<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\Recipe;
use App\Services\ProductionService;
use Illuminate\Http\Request;
use function redirect;
use function view;

class ProductionController extends Controller
{
    
    protected $service;
    
    public function __construct(ProductionService $service) {
        $this->service = $service;
    }
    
    
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
        $return = $this->service->store($request->all());
        
        $message = [
            "message" => $return["message"],
            "type"=> $return["type"]
        ];
        
        return redirect()->route($return["route"])->with($message);
        
    }
    
    public function edit($id)
    {
        $production = Production::find($id);
        $recipe = Recipe::find($production->recipe_id);
        if(!$production){
            $message = [
                "message" => "Item não Encontrado!",
                "type"=>"warning"
            ];
            return redirect()->route('production.index')->with($message);
        }
        
        return view("production.edit",["production"=>$production, "recipe"=>$recipe]);
    }

    public function update(Request $request, $id)
    {
        $return = $this->service->update($request->all(),$id);
        
        $message = [
            "message" => $return["message"],
            "type"=> $return["type"]
        ];
        
        return redirect()->route($return["route"], $id)->with($message);
        
    }

    public function destroy(Request $request)
    {
        $return = $this->service->destroy($request->all());
        
        $message = [
            "message" => $return["message"],
            "type"=> $return["type"]
        ];
        
        return redirect()->route($return["route"])->with($message);
    }
}
