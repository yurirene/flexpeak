<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateOperationRequest extends FormRequest
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
            "item" => "required",
            "operation_type" => "required",
            "volume" => ["required","numeric"]
        ];
    }
    
    public function messages() {
        return [
            'item.required' => 'É necessário Selecionar um Item',
            'operation_type.required' => 'É necessário selecionar um Tipo',
            'volume.required' => 'É necessário informar o Volume em Litros',
            'volume.numeric' => 'Insira apenas números no campo Volume'
        ];
    }

}
