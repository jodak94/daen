<?php

namespace Modules\Pacientes\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Paciente extends Model
{

    protected $table = 'pacientes__pacientes';
    public $translatedAttributes = [];
    protected $fillable = ['nombre', 'apellido', 'sexo', 'fecha_nacimiento', 'cedula'];
    protected $appends = ['edad'];
    public static $sexos = [
      'femenino' => 'Femenino',
      'masculino' => 'Masculino'
    ];
    public function analisis(){
      return $this->hasMany('Modules\Analisis\Entities\Analisis');
    }

    public function getEdadAttribute(){
      return Carbon::parse($this['fecha_nacimiento'])->age;
    }

}
