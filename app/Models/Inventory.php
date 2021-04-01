<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = "inventories";
    protected $fillable = ["name", "current_qty", "minimal_qty", "is_fragrance"];
    
    public function updateStock(Operation $operation, array $reverse=null):bool
    {
        $item = $this::find($operation->inventory_id);
        $current_qty = floatval($item->current_qty);
        if($reverse){
            if($reverse['type']==1){
                $current_qty = $current_qty - floatval($reverse['volume']);
            }
            if($reverse['type']==2){
                $current_qty = $current_qty + floatval($reverse['volume']);
            }           
        }
        
        $new_qty = 0;
        
        if($operation->operation_type_id==1){
            $new_qty = $current_qty + floatval($operation->volume);
        }
        if($operation->operation_type_id==2){
            $new_qty = $current_qty - floatval($operation->volume);
        }
        $item->current_qty = $new_qty;
        if(!$item->save()){
            return false;
        }
        return true;
    }
    public function updateStockOnDelete(Operation $operation, array $reverse=null):bool
    {
        $item = $this::find($operation->inventory_id);
        $current_qty = floatval($item->current_qty);
        if($reverse){
            if($reverse['type']==1){
                $current_qty = $current_qty - floatval($reverse['volume']);
            }
            if($reverse['type']==2){
                $current_qty = $current_qty + floatval($reverse['volume']);
            }           
        }
       
        $item->current_qty = $current_qty;
        if(!$item->save()){
            return false;
        }
        return true;
    }
    
}
