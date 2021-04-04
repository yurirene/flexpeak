<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\Operation;
use Exception;
use InvalidArgumentException;
use stdClass;

class OperationService
{
    
    public function store(array $data):array
    {
        try {
            
            $operation = $this->createOperation($data);

            if(!$this->haveStock($operation)){
                throw new Exception("Estoque Insuficiênte!");
            }

            if(!$operation->save()){
                throw new Exception("Erro ao Registrar!");
            }
            if(!$this->updateStock($operation)){
                $operation->delete();
                throw new Exception("Erro ao Atualizar o Estoque. Tente Novamente!");
            }
            return [
                "success"=>true,
                "message"=>"Registro Inserido com Sucesso!",
                "type"=>"success",
                "data"=>$operation,
                "route" =>"operation.index"
            ];
        } catch (Exception $e){
            return [
                "success"=>false,
                "message"=> $e->getMessage(),
                "type"=>"danger",
                "route" =>"operation.index"
            ];
        }
    }

    public function update(array $data, $id):array
    {
        try {
            
            $operation = Operation::find($id);
            if (!$operation) {
                throw new InvalidArgumentException("Registro Inválido!");
            }

            $old_data = new stdClass();
            $old_data->type = $operation->operation_type_id;
            $old_data->volume = $operation->volume;
            
            $operation->inventory_id = $data["item"];
            $operation->operation_type_id = $data["operation_type"];
            $operation->volume = $data["volume"];

            if(!$this->haveStock($operation)){
                throw new Exception("Estoque Insuficiênte!");
            }

            if(!$operation->save()){
                throw new Exception("Erro ao Atualizar!");
            }
            if(!$this->updateStock($operation, $old_data)){
                $operation->operation_type_id = $old_data->type;
                $operation->volume = $old_data->volume;
                $operation->save();
                throw new Exception("Erro ao Atualizar o Estoque. Tente Novamente!");
            }
            return [
                "success"=>true,
                "message"=>"Registro Atualizado com Sucesso!",
                "type"=>"success",
                "route" =>"operation.index"
            ];
        } catch (Exception $e){
            return [
                "success"=>false,
                "message"=> $e->getMessage(),
                "type"=>"danger",
                "route" => [
                    "operation.edit",
                    "id" => $id
                ]
            ];
        }
    }

    public function destroy($id):array
    {
        try {
            
            $operation = Operation::find($id);
            if (!$operation) {
                throw new InvalidArgumentException("Registro Inválido!");
            }

            $old_data = new stdClass();
            $old_data->type = $operation["operation_type_id"];
            $old_data->volume = $operation["volume"];
            
            if (!$operation->delete()) {
                throw new Exception("Erro ao Excluir Registro!");
            }
            if (!$this->updateStock($operation, $old_data, false)) {
                $operation->restore();
                throw new Exception("Erro ao Atualizar o Estoque. Tente Novamente!");
            }
            $operation->forceDelete();
            
            return [
                "success"=>true,
                "message"=>"Registro Excluído com Sucesso!",
                "type"=>"success",
                "route" =>"operation.index"
            ];
        } catch (Exception $e){
            return [
                "success"=>false,
                "message"=> $e->getMessage(),
                "type"=>"danger",
                "route" =>"operation.index"
            ];
        }
    }
    
    public function createOperation(array $data): Operation
    {
        $operation = new Operation();
        $operation->inventory_id = $data["item"];
        $operation->operation_type_id = $data["operation_type"];
        $operation->volume = $data["volume"];
        return $operation;
    }
    
    public function haveStock(
            Operation $operation, 
            stdClass $old_data = null
        ):bool
    {
        if($operation->operation_type_id == 1){
            return true;
        }
        $item = Inventory::find($operation->inventory_id);

        $current_qty = floatval($item->current_qty);
        
        // if you are upgrading you need to know what the old quantity 
        // value of this item is
        
        if($old_data){
            $current_qty = $this->reverseQty($old_data, $current_qty);
        }
        
        //checks if there is enough volume
        
        $result = $current_qty - floatval($operation->volume);
        
        
        if($result < 0){
            return false;
        }
        return true;
        
    }
    
    public function updateStock(
            Operation $operation,
            stdClass $old_data=null,
            bool $newQty = true
        ):bool
    {
        $item = Inventory::find($operation->inventory_id);
        $current_qty = floatval($item->current_qty);
        if($old_data){
            $current_qty = $this->reverseQty($old_data, $current_qty);
        }
        
        $item->current_qty = $current_qty;
        
        if($newQty){
           $item->current_qty = $this->newQuantity($operation, $current_qty);
        }
        
        
        if(!$item->save()){
            return false;
        }
        return true;
    }
    
    
    /**
     * Return the old current_qty value of inventory_id
     * @param stdClass $old_data
     * @param type $current_qty
     * @return float
     */
    public function reverseQty(stdClass $old_data, $current_qty): float
    {
        if($old_data->type==1){
            $current_qty -= floatval($old_data->volume);
        }
        if($old_data->type==2){
            $current_qty += floatval($old_data->volume);
        }     
        
        return $current_qty;
    }
    /**
     * Returns the new value to be updated in the DB
     * @param Operation $operation
     * @param type $current_qty
     * @return float
     */
    public function newQuantity(Operation $operation, $current_qty):float
    {
        $new_qty=0;
        if ($operation->operation_type_id == 1) {
            $new_qty = $current_qty + floatval($operation->volume);
        }
        if ($operation->operation_type_id == 2) {
            $new_qty = $current_qty - floatval($operation->volume);
        }
        return $new_qty;
    }
    
}