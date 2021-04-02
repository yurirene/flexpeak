<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Operation extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    
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
    
    
}
