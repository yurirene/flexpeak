<?php

namespace App\Services;

use App\Models\Recipe;
use Exception;
use InvalidArgumentException;

class RecipeService 
{
    
    public function store(array $data):array
    {
        try {
            
            $recipe = new Recipe();
            $recipe->name = $data["name"];
            
            $parameters = array();

            foreach ($data["ingredients"]['id'] as $k => $v) {
                $parameters[$v] = [
                    "percent" => $data["ingredients"]['percent'][$k]
                ];
            }

            if (!$recipe->save()) {
                throw new Exception("Erro ao Registrar!");
            }
            $recipe->components()->sync($parameters);

            return [
                "success"=>true,
                "message"=>"Registro Inserido com Sucesso!",
                "type"=>"success",
                "route" =>"recipe.index"
            ];
        } catch (Exception $e){
            return [
                "success"=>false,
                "message"=> $e->getMessage(),
                "type"=>"danger",
                "route" =>"recipe.create"
            ];
        }
    }

    public function update(array $data, int $id):array
    {
        try {
            $item = Recipe::find($id);

            if (!$item) {
                throw new InvalidArgumentException("Registro Inválido");
            }

            $item->name = $data["name"];


            $parameters = array();

            foreach ($data["ingredients"]['id'] as $k => $v) {
                $parameters[$v] = [
                    "percent" => $data["ingredients"]['percent'][$k]
                ];
            }

            if (!$this->verifyPercent($data["ingredients"]['percent'])) {
                throw new InvalidArgumentException("Os percentuais não totalizam 100%");
            }

            if (!$item->save()) {
                throw new Exception("Erro ao Atualizar Registro");
            }


            $item->components()->sync($parameters);
            
            return [
                "success"=>true,
                "message"=>"Registro Atualizado com Sucesso!",
                "type"=>"success",
                "route" =>"recipe.index"
            ];
        } catch (Exception $e){
            return [
                "success"=>false,
                "message"=> $e->getMessage(),
                "type"=>"danger",
                "route" => [
                    "recipe.edit",
                    "id" => $id
                ]
            ];
        }
    }

    public function destroy($id):array
    {
        try {
            $item = Recipe::find($id);
            if (!$item) {
                throw new InvalidArgumentException("Registro Inválido");
            }

            if (!$item->delete()) {
                throw new Exception("Erro ao Excluir Registro");
            }
            return [
                "success"=>true,
                "message"=>"Registro Excluído com Sucesso!",
                "type"=>"success",
                "route" =>"recipe.index"
            ];
        } catch (Exception $e){
            return [
                "success"=>false,
                "message"=> $e->getMessage(),
                "type"=>"danger",
                "route" =>"recipe.index"
            ];
        }
    }
    
}