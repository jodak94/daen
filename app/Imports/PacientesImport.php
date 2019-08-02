<?php

namespace App\Imports;

use Modules\Pacientes\Entities\Paciente;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PacientesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Producto([
            'nombre' => $row['nombre'],
            'apellido'=> $row['apellido'],
            'cedula'=> $row['cedula'],
            'fecha_nacimiento'=> $row['fecha_nacimiento'],
            'sexo' => $row['sexo']

        ]);
    }

}
