<?php

namespace Modules\Analisis\Entities;


use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Analisis extends Model
{
    protected $table = 'analisis__analises';
    public $translatedAttributes = [];
    protected $fillable = [];
    protected $appends = ['paciente_nombre', 'creado_por', 'fecha_format'];

    public function paciente(){
      return $this->belongsTo('Modules\Pacientes\Entities\Paciente');
    }

    public function resultados(){
      return $this->hasMany('Modules\Analisis\Entities\Resultado');
    }

    public function user(){
      return $this->belongsTo('Modules\User\Entities\Sentinel\User', 'created_by');
    }

    public function getPacienteNombreAttribute(){
      return $this->paciente()->first()->nombre . ' ' . $this->paciente()->first()->apellido . ' - ' . $this->paciente()->first()->cedula_format;
    }

    public function getCreadoPorAttribute(){
      return $this->user->first_name . ' ' . $this->user->last_name;
    }

    public function getFechaFormatAttribute(){
      $date = Carbon::parse($this->fecha);
      return $date->format('d/m/Y');
    }
}
