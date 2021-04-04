<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportWithDateRequest extends FormRequest
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
            "start" => "required|date_format:d/m/Y",
            "end" => "date_format:d/m/Y|after_or_equal:start|nullable"
        ];
    }
    
    public function messages()
    {
        return [
            "start.required" => "Selecione uma data",
            "start.date_format" => "Formato de Data Inválido",
            "end.after_or_equal" => "Selecione uma data igual ou posterior a Data de Início",
            "end.date_format" => "Formato de Data Inválido"
        ];
        
    }
}
