<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    protected $table = "recipes";
    protected $fillable = ["name"];
   
    public function components()
    {
        return $this->belongsToMany(Inventory::class, 
                "recipe_components", 
                "recipe_id", 
                "inventory_id")
                ->withPivot(['percent']);        
    }
    public function productions()
    {
        return $this->hasMany(Productions::class, 
                "productions", "id", "recipe_id");
        
    }
    
}
