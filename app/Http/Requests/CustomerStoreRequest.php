<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
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
            'cpf'=>'required|max:14',
            'nome'=>'required|max:255',
            'email'=>'required|email|max:255',
            'genero'=>'required|max:9',            
        ];
    }

    public function messages()
    {
        return [            
            'cpf.required' => 'CPF  é obrigatório',
            'cpf.max'=>'Você excedeu o número máximo caracteres deste campo',                   
          
            'nome.required' => 'Nome é obrigatório',
            'nome.max'=>'Você excedeu o número máximo caracteres deste campo',                   
          
            'email.required' => 'E-mail é obrigatório',
            'email.email' => 'E-mail inválido',
            'email.max'=>'Você excedeu o número máximo caracteres deste campo',                  
          
            'genero.required' => 'Gênero é obrigatório',
            'genero.max'=>'Você excedeu o número máximo caracteres deste campo',                  
            
          
     
        ];
    }
}
