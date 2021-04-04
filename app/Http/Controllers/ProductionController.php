<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRequest;
use App\Http\Requests\StoreUpdateProductionRequest;
use App\Models\Production;
use App\Models\Recipe;
use App\Services\ProductionService;
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
        $list = Production::with("recipe")->orderBy("created_at", "desc")->paginate(5);
        
        return view("production.index", ["list"=>$list]);
    }

    public function create()
    {
        $recipes = Recipe::with("components")->get();
        return view("production.create",["recipes"=>$recipes]);
    }

    public function store(StoreUpdateProductionRequest $request)
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

    public function update(StoreUpdateProductionRequest $request, $id)
    {
        $return = $this->service->update($request->all(),$id);
        
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
