<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Operation extends Model
{
    use HasFactory;
    protected $table = "operations";
    protected $fillable = ["volume", "inventory_id", "operation_type_id"];
    
    public function operationType()
    {
        return $this->hasOne(OperationType::class, "id", "operation_type_id");
    }
    
    public function inventory()
    {
        return $this->hasOne(Inventory::class, "id", "inventory_id");        
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
