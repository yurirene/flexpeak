<?php

namespace App\Services;

use App\Models\Inventory;
use Exception;
use InvalidArgumentException;
class InventoryService 
{
    
    public function store(array $data):array
    {
        try{
            $item = new Inventory();
            $item->name = $data["name"];
            $item->minimal_qty = $data["minimal_qty"];
            $item->current_qty = 0;

            if (isset($data["is_fragrance"])) {
                $item->is_fragrance = 1;
            }

            if (!$item->save()){
                throw new Exception("Erro ao Registrar!");
            }
            return [
                "success"=>true,
                "message"=>"Registro Inserido com Sucesso!",
                "type"=>"success",
                "route" =>"inventory.index"
            ];
        } catch (Exception $e){
            return [
                "success"=>false,
                "message"=> $e->getMessage(),
                "type"=>"danger",
                "route" =>"inventory.create"
            ];
        }
    }

    public function update(array $data, int $id):array
    {
        try{
            $item = Inventory::find($id);
            if (!$item) {
                throw new InvalidArgumentException("Registro não Encontrado!");
            }

            $item->minimal_qty = $data["minimal_qty"];
            $item->name = $data["name"];
            $item->is_fragrance = 0;
            if (isset($data["is_fragrance"])) {
                $item->is_fragrance = 1;
            }
            if (!$item->save()) {
                throw new Exception("Erro ao Atualizar!");
            }
            
            return [
                "success"=>true,
                "message"=>"Registro Atualizado com Sucesso!",
                "type"=>"success",
                "route" =>"inventory.index"
            ];
        } catch (Exception $e){
            return [
                "success"=>false,
                "message"=> $e->getMessage(),
                "type"=>"danger",
                "route" =>"inventory.edit"
            ];
        }
    }

    public function destroy(array $data):array
    {
        try {
            $item = Inventory::find($data["id"]);
            if (!$item) {
                throw new InvalidArgumentException("Registro não Encontrado!");
            }

            if (!$item->delete()) {
                throw new Exception("Erro ao Excluir Registro!");
            }
            return [
                "success"=>true,
                "message"=>"Registro Excluído com Sucesso!",
                "type"=>"success",
                "route" =>"inventory.index"
            ];
        } catch (Exception $e){
            return [
                "success"=>false,
                "message"=> $e->getMessage(),
                "type"=>"danger",
                "route" =>"inventory.index"
            ];
        }
        
    }
    
}