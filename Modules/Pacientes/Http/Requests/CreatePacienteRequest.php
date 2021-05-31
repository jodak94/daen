<?php

namespace Modules\Pacientes\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreatePacienteRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
          'nombre'  => 'required',
          'apellido' => 'required',
          'cedula' => 'nullable|unique:pacientes__pacientes',
          'sexo'     => 'required|in:masculino,femenino',
        ];
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
        return [
          'required'    => 'El campo :attribute no puede quedar vacio.',
          'unique' => 'El campo :attribute debe ser único. Ya existe ese valor.',
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
