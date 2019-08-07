<?php

namespace Modules\Plantillas\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreatePlantillaRequest extends BaseFormRequest
{
    public function rules()
    {
        return ['determinacion' => 'required'];
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
        return [];
    }

    public function translationMessages()
    {
        return [];
    }
}
