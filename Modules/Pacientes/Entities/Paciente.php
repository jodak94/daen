<?php

namespace Modules\Pacientes\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Paciente extends Model
{

    protected $table = 'pacientes__pacientes';
    public $translatedAttributes = [];
    protected $fillable = ['nombre', 'apellido', 'sexo', 'fecha_nacimiento', 'cedula', 'empresa_id'];
    protected $appends = ['edad', 'cedula_format', 'empresa_format', 'sexo_format', 'fecha_nacimiento_format'];
    public static $sexos = [
      'femenino' => 'Femenino',
      'masculino' => 'Masculino'
    ];
    public function analisis(){
      return $this->hasMany('Modules\Analisis\Entities\Analisis');
    }

    public function empresa(){
      return $this->belongsTo('Modules\Empresas\Entities\Empresa');
    }

    public function getEdadAttribute(){
      return Carbon::parse($this['fecha_nacimiento'])->age;
    }

    public function getFechaNacimientoFormatAttribute(){
      return Carbon::parse($this['fecha_nacimiento'])->format('d/m/Y');
    }

    public function getCedulaFormatAttribute(){
      if(isset($this['cedula']) and $this['cedula'] != '')
        return number_format($this['cedula'], 0, ',', '.');
      else
        return '--';
    }

    public function getSexoFormatAttribute(){
      return ucfirst($this['sexo']);
    }

    public function getEmpresaFormatAttribute(){
      if(isset($this['empresa']))
        return $this->empresa->nombre;
      else
        return '--';
    }

}
