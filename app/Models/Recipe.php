<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    protected $table = "recipes";
    protected $fillable = ["name", "per_water", "per_alcohol", "per_fragrance", "fragrance_id"];
    
    public function verifyPercent():bool {
        $water = floatval($this->per_water);
        $alcohol = floatval($this->per_alcohol);
        $fragrance = floatval($this->per_fragrance);
        $percent = $water + $alcohol + $fragrance;
        if($percent!=100){
            return false;
        }
        return true;
    }
    
    public function inventory()
    {
        return $this->hasOne(Inventory::class, "id", "fragrance_id");        
    }
    
}
