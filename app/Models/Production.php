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
    
    public function haveStock(array $reverse = null):bool {
        $item = Inventory::find($this->inventory_id);
        $result = 0;
        $current_qty = floatval($item->current_qty);
        
        if($reverse){
            if($reverse['type']==1){
                $current_qty = $current_qty - floatval($reverse['volume']);
            }
            if($reverse['type']==2){
                $current_qty = $current_qty + floatval($reverse['volume']);
            }           
        }
        
        if($this->operation_type_id == 2){
            $result = $current_qty - floatval($this->volume);
        }
        
        if($result < 0){
            return false;
        }
        return true;
        
    }
    
}
