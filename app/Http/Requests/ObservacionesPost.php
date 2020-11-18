<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObservacionesPost extends FormRequest
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
            'incidencia_con' => 'required|max:150',
            'objeto_incidencia' => 'required|max:150',
            'comentario' => 'required|max:300',
            'tipo_pago_id' => 'required|exists:App\Models\PaymentType,id|numeric',
            'pago_id' => 'required|exists:App\Models\Payment,id|numeric',
        ];
    }
}
