<?php

namespace App\Http\Requests;

use App\Rules\SumPercentage;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required",
            "ingredients" => "required|array",
            "ingredients.*" => "required",
            "ingredients.percent"=> new SumPercentage(),
            "ingredients.percent.*" => [
                "required",
                "numeric",
                "min:0"
            ],
            "ingredients.id.*" => "required|distinct|numeric"
        ];
    }
    
    public function messages() {
        return [
            'name.required' => "Informe um nome para essa fórmula",
            'ingredients.percent' => "A Soma das Pocentagens não é igual a 100%",
            'ingredients.percent.*.required' => "Informe a Porcentagem",
            'ingredients.percent.*.numeric' => "Informe Valores numéricos maiores que 0",
            'ingredients.percent.*.min' => "Informe Valores numéricos maiores que 0",
            'ingredients.id.*.required' => "Selecione um Ingrediente",
            'ingredients.id.*.distinct' => "Selecione Ingredientes Diferentes",
            'ingredients.*' => "Adicione Ingredientes"
            
            
        ];
    }

}
