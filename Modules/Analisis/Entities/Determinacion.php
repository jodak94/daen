<?php

namespace Modules\Analisis\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Log;
class Determinacion extends Model
{

    protected $table = 'analisis__determinacions';
    public $translatedAttributes = [];
    protected $fillable = ['tipo_referencia', 'titulo', 'rango_referencia', 'unidad_medida', 'subseccion_id', 'orden'];
    protected $appends = ['rango_referencia_format'];

    public static $tipos_refs = [
      'rango' => 'Rango',
      'rango_edad' => 'Rango considerando edad (Adultos / Niños)',
      'rango_sexo' => 'Rango considerando sexo',
      'booleano' => 'Positivo / Negativo',
      'reactiva' => 'Reactivo / No Reactivo',
      'sin_referencia' => '--'
    ];

    public function subseccion(){
      return $this->belongsTo('Modules\Analisis\Entities\Subseccion');
    }

    public function getRangoReferenciaFormatAttribute(){
      if(!isset($this['rango_referencia']))
      return '';
      if($this['rango_referencia'][0] == '0' && $this['tipo_referencia'] == 'rango'){
        $rango = explode('-', $this['rango_referencia']);
        $rango[0] = 'Inferior a';
        return 'Inferior a ' . $rango[1];
      }
      if($this['tipo_referencia'] == 'reactiva' || $this['tipo_referencia'] == 'booleano'){
        return ucfirst(str_replace('_', ' ', $this['rango_referencia']));
      }
      return $this['rango_referencia'];
    }



}
