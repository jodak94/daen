<?php

namespace Modules\Pacientes\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Log;
class UpdatePacienteRequest extends BaseFormRequest
{
    public function rules()
    {
	$paciente = $this->route('paciente');
        return [
          'nombre'  => 'required',
          'apellido' => 'required',
          'cedula' =>  'nullable|numeric|unique:pacientes__pacientes,cedula,'.$paciente->id,
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
