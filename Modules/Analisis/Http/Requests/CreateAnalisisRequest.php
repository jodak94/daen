<?php

namespace Modules\Analisis\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateAnalisisRequest extends BaseFormRequest
{
    public function rules()
    {
        return ['paciente_id' => 'required'];
    }

    public function translationRules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return ['paciente_id.required' => 'El campo Paciente es requerido'];
    }

    public function translationMessages()
    {
        return [];
    }
}
