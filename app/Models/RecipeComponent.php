<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeComponent extends Model
{
    use HasFactory;
    protected $table = "recipe_components";
    protected $fillable = ["invetory_id", "recipe_id"];
    
    
    
}
