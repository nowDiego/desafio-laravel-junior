<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurshaseOrderStoreRequest extends FormRequest
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
            'valor_total'=>'required',
            'customer'=>'required|exists:customers,id',
            'status'=>'required|exists:order_statuses,id',
            'orderItems'=>'required'
        ];
    }

    public function messages()
    {
        return [            
            'valor_total.required' => 'Valor total é obrigatório',
          
            'customer.required' => 'Cliente é obrigatório',
            'customer.exists' => 'Cliente Inválido',

            'status.required' => 'Status do Pedido é obrigatório',
            'status.exists' => 'Status do Pedido Inválido',
         
            'orderItems.required' => 'Itens do Pedido é obrigatório',
     
        ];
    }
}
