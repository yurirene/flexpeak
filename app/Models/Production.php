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
    
    public function operations()
    {
        return $this->belongsToMany(Operation::class, 
                "production_operations", 
                "production_id", 
                "operation_id");        
    }
    
}
