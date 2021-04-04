<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\Production;
use App\Models\Recipe;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
class ReportService
{
    public function reportChart(array $data=null):array
    { 
        $mostProduced = $this->mostProduced($data);
        $return = array();
        $return["labels"]= array();
        $return["data"]= array();
        foreach($mostProduced as $chart){
            
            $return["labels"][] = $chart["name"];
            $return["data"][] = $chart["volume"];
        }
        $return["colors"]=$this->generateRandomColor(count($mostProduced));
        return $return;
    }
    
    
    public function mostProduced(array $data=null):array
    { 
        $mostProduced = DB::table('productions')
                ->leftJoin('recipes', 'recipe_id', '=', 'recipes.id')
                ->select(
                        'recipe_id', 'recipes.name as name',
                        DB::raw('SUM(volume) as volume'),
                        DB::raw('COUNT(recipe_id) as quantity')
                    );
        $mostProduced = $mostProduced->groupBy("recipe_id");
        
        if($data){
            $start = Carbon::createFromFormat('d/m/Y', $data['start'])->format('Y-m-d');
            $mostProduced = $mostProduced
                ->where("productions.created_at",'>=', $start);
            if($data['end']){
                $end = Carbon::createFromFormat('d/m/Y', $data['end'])->format('Y-m-d');
                $mostProduced = $mostProduced->where("productions.created_at", '<=', $end);
            }
            
        }
        $mostProduced = $mostProduced->get();
        $return = array();
        foreach($mostProduced as $produced){
            
            $return[] = [
                "name"=>$produced->name,
                "volume" =>floatval($produced->volume),
                "quantity"=>floatval($produced->quantity)  
            ];
        }
        return $return;
        
    }
    
    public function generateRandomColor($qty):array
    {
        $rgbColor = array();
        $colors = array();
        for($i=0; $i<$qty; $i++){
            foreach(array('r', 'g', 'b') as $color){
                //Generate a random number between 0 and 255.
                 $rgbColor[$color] = mt_rand(0, 255);
            }
            $colors[] = "rgba(".implode(",",$rgbColor).",1)";
        }
        return $colors;
    }
    
    public function mostUsedFragranceChart(array $data = null):array
    {
        $useds = $this->mostUsedFragrance($data);
        $chart = array();
        foreach($useds as $key => $used){
            $chart["labels"][] = $used[0]["fragrance_name"];
            $chart["data"][] = $key;
        }
        $chart["colors"] = $this->generateRandomColor(count($useds));
        return $chart;
        
    }
    
    public function mostUsedFragrance(array $data = null):array
    {
        $inventories = Inventory::with("recipes")
                ->where("is_fragrance", "=", 1)
                ->get();
        
        $recipes= array();
        foreach($inventories as $inventory){
            foreach($inventory->recipes as $recipe){
                $recipes[$inventory->name][]=[
                    "fragrance_name" => $inventory->name,
                    "recipe_id" =>$recipe->id,
                    "recipe_name"=>$recipe->name,
                    "frangrance_id" => $inventory->id
                ];
            }
        }
        $count =0;
        $mostUsed = array();
        
        foreach($recipes as $fragrance){
            foreach($fragrance as $recipe){
                $productions = Production::where(
                        "recipe_id", 
                        '=', 
                        $recipe['recipe_id']
                );
                if ($data) {
                    $start = Carbon::createFromFormat('d/m/Y', $data['start'])->format('Y-m-d');
                    $productions = $productions
                            ->where("created_at", '>=', $start);
                    if ($data['end']) {
                        $end = Carbon::createFromFormat('d/m/Y', $data['end'])->format('Y-m-d');
                        $productions = $productions->where("created_at", '<=', $end);
                    }
                }
                $productions = $productions->count();
                $count += $productions;
            }
            $mostUsed[$count]=[
                $fragrance[0]
            ];
            $count=0;
        }
        krsort($mostUsed);
        return $mostUsed;
    }
    
    public function index():array
    {
        $recipes = Recipe::get()->count();
        $productions = Production::get()->count();
        $invetories = Inventory::get()->count();
        return array(
            "recipes" => $recipes,
            "productions" =>$productions,
            "inventories" => $invetories
        );
    }
    
}
