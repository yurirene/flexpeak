<?php

namespace App\Services;

use App\Models\Production;
use App\Models\Recipe;
use Exception;
use InvalidArgumentException;

class ProductionService
{
    protected $operation;
    public function __construct(OperationService $operation) {
        $this->operation = $operation;
    }
    
    public function store(array $data):array
    {
        try {
            
            $item = new Production();
            $item->recipe_id = $data["recipe"];
            $item->volume = $data["volume"];
            
            $operations_inserted = array();
            $operations = $this->createStoreOperations($item);
            foreach($operations as $operation){
                $op = $this->operation->createOperation($operation);
                $return = $this->operation->haveStock($op);
                if(!$return){
                    throw new Exception("Existe ao menos 1 "
                            . "Ingrediente sem estoque suficiente");
                }
                
            }
            foreach($operations as $operation){
                
                $return = $this->operation->store($operation);
                $operations_inserted[] = $return["data"]->id;
                
            }
            
            if (!$item->save()) {
                throw new Exception("Erro ao Inserir Registro");
            }
            
            $item->operations()->sync($operations_inserted);
            
            return [
                "success"=>true,
                "message"=>"Registro Inserido com Sucesso!",
                "type"=>"success",
                "route" =>"production.index"
            ];
        } catch (Exception $e){
            return [
                "success"=>false,
                "message"=> $e->getMessage(),
                "type"=>"danger",
                "route" =>"production.create"
            ];
        }
    }

    public function update(array $data, int $id):array
    {
        try {
            
            $item = Production::with("operations")->find($id);
            if (!$item) {
                throw new InvalidArgumentException("Registro inválido");
            }
            
            $old_volume = floatval($item->volume);
            
            $item->volume = $data["volume"];
                        
            if (!$item->save()) {
                throw new Exception("Erro ao Atualizar!");
            }
            
            $operations = $this->createUpdateOperations($item, $old_volume);
            
            foreach($operations as $operation){
                
                $this->operation->update($operation, $operation["id"]);
                
            }
            return [
                "success"=>true,
                "message"=>"Registro Atualizado com Sucesso!",
                "type"=>"success",
                "route" =>"production.index"
            ];
        } catch (Exception $e){
            return [
                "success"=>false,
                "message"=> $e->getMessage(),
                "type"=>"danger",
                "route" => [
                    "production.edit",
                    "id" => $id
                ]
            ];
        }
    }

    public function destroy($id):array
    {
        try {
            $item = Production::with("operations")->find($id);
            if (!$item) {
                throw new InvalidArgumentException("Registro inválido");
            }
            $operations = $this->createDeleteOperations($item);
            
            foreach($operations as $operation){
                
                $this->operation->destroy($operation);
                
            }
            if (!$item->delete()) {
                throw new Exception("Erro ao Excluir!");
            }
            
            return [
                "success"=>true,
                "message"=>"Registro Excluído com Sucesso!",
                "type"=>"success",
                "route" =>"production.index"
            ];
        } catch (Exception $e){
            return [
                "success"=>false,
                "message"=> $e->getMessage(),
                "type"=>"danger",
                "route" =>"production.index"
            ];
        }
    }
    
    public function createStoreOperations(Production $production): array
    {
        $data = array();
        $volume = 0;

        $recipe = Recipe::with("components")->find($production->recipe_id);
        
        foreach ($recipe->components as $item) {

            
            $volume = (floatval($item->pivot->percent) / 100) 
                    * floatval($production->volume);
            
            $data[] = [
                "item"=> $item->pivot->inventory_id,
                "operation_type" => 2,
                "volume" => $volume
            ];
        }
        return $data;
    }
    
    public function createUpdateOperations(
            Production $production, float $old_volume): array
    {
        $data = array();
        $new_volume = 0;

        
        foreach ($production->operations as $item) {
            
            $percent = (floatval($item->volume)*100)/$old_volume;
        
            $new_volume = ($percent / 100)* floatval($production->volume);
            
            $data[] = [
                "id" => $item->id,
                "item"=> $item->inventory_id,
                "operation_type" => 2,
                "volume" => $new_volume
            ];
        }
        return $data;
    }
    
    public function createDeleteOperations(Production $production): array
    {
        $data = array();

        
        foreach ($production->operations as $item) {
            
            $data[] = [
                "id" => $item->id,
                "item"=> $item->inventory_id,
                "operation_type" => 2,
                "volume" => $item->volume
            ];
        }
        return $data;
    }
    
}