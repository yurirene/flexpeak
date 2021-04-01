<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;
    protected $table = "productions";
    protected $fillable = ["volume", "recipe_id"];
    
    public function recipe()
    {
        return $this->hasOne(Recipe::class, "id", "recipe_id");        
    }
    
    public function haveStock():bool {
        
        
        $recipe = Recipe::with("components")->find($this->recipe_id);
        
        foreach($recipe->components as $item){
            $volume = (floatval($item->pivot->percent)/100)*$this->volume;
            $current_qty = floatval($item->current_qty);
            
            if($volume > $current_qty){
                return false;
            }
            
        }
        return true;
    }
    public function updateStock(array $reverse=null):void
    {
        $volume = 0;
        
        $recipe = Recipe::with("components")->find($this->recipe_id);
        
       
        
        
        foreach($recipe->components as $item){
            $volume = (floatval($item->pivot->percent)/100)*$this->volume;
            
            $operation = new Operation();
            $operation->operation_type_id = 2;
            $operation->volume = $volume;
            $operation->inventory_id = $item->pivot->inventory_id;
            if ($reverse) {
                $reverse["volume"] = (floatval($item->pivot->percent) / 100)
                        * $reverse["volume"];
            }
            if($operation->save()){
                 
                (new Inventory())->updateStock($operation, $reverse);
            }
                    
        }
    }
}
