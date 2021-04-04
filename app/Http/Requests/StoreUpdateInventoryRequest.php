<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateInventoryRequest extends FormRequest
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
            "minimal_qty" => "numeric|min:0"
        ];
    }
    
    public function messages() {
        return [
            'name.required' => 'É necessário preencher o campo Nome',
            'minimal_qty.numeric' => 'Insira apenas números no campo Quantidade Mínima',
            'minimal_qty.min' => 'Insira valores maior ou igual a 0'
        ];
    }
}
