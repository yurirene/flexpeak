<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = "inventories";
    protected $fillable = ["name", "current_qty", "minimal_qty", "is_fragrance"];
    
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 
                "recipe_components", 
                "inventory_id", 
                "recipe_id");        
        
    }
    
}
