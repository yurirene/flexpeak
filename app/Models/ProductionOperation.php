<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionOperation extends Model
{
    use HasFactory;
    protected $table = "production_operations";
    protected $fillable = ["operation_id", "recipe_id"];
    
    
    
}
