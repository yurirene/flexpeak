<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    protected $table = "recipes";
    protected $fillable = ["name"];
    
    
    public function verifyPercent(array $percents):bool {
        
        $total=0;
        
        foreach($percents as $percent){
            $total += floatval($percent);
        }
        if($total!=100){
            return false;
        }
        return true;
    }
    
   
    public function components()
    {
        return $this->belongsToMany(Inventory::class, 
                "recipe_components", 
                "recipe_id", 
                "inventory_id")
                ->withPivot(['percent']);        
    }
    
}
