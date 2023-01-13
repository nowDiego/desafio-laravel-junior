<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nome_produto'=>'required|max:255',
            'cod_barra'=>'required',
            'valor_unitario'=>'required'
        ];
    }


    public function messages()
    {
        return [            
            'nome_produto.required' => 'Nome do Produto é obrigatório',
            'nome_produto.max'=>'Você excedeu o número máximo caracteres deste campo',                   
          
            'cod_barra.required' => 'Código de Barra é obrigatório',
          
            'valor_unitario.required' => 'Valor unitário é obrigatório',                         
          
     
        ];
    }
}
