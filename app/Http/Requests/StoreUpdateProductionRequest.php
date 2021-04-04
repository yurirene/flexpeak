<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProductionRequest extends FormRequest
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
            "recipe" => "required|numeric",
            "volume" => "required|numeric|min:1"
        ];
    }
    
    public function messages() {
        return [
            'recipe.required' => 'É necessário selecionar uma Fórmula',
            'volume.numeric' => 'Insira apenas números no campo Volume',
            'volume.min' => 'Insira valor maior ou igual a 1'
        ];
    }
}
