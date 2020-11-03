<?php

namespace Modules\Analisis\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Log;
use DB;
class Determinacion extends Model
{

    protected $table = 'analisis__determinacions';
    public $translatedAttributes = [];
    protected $fillable = ['tipo_referencia', 'titulo', 'rango_referencia', 'unidad_medida', 'subseccion_id', 'orden', 'multiples_lineas', 'trato_especial', 'tipo_trato', 'texto_ref', 'texto_h'];
    protected $appends = ['rango_referencia_format', 'helper'];

    public static $tipos_refs = [
      'rango' => 'Rango',
      'rango_edad' => 'Rango considerando edad (Adultos / Niños)',
      'rango_sexo' => 'Rango considerando sexo',
      'booleano' => 'Positivo / Negativo',
      'reactiva' => 'Reactivo / No Reactivo',
      'sin_referencia' => '--'
    ];

    public static $tipos_tratos = [
      null => '--',
      'antibiograma' => 'Antibiograma',
      'select' => 'Selección',
      'bhcg' => 'Bhcg'
    ];

    public function subseccion(){
      return $this->belongsTo('Modules\Analisis\Entities\Subseccion');
    }

    public function getRangoReferenciaFormatAttribute(){
      if(!isset($this['rango_referencia']))
      return '';
      if($this['rango_referencia'][0] == '0' && $this['rango_referencia'][1] == '-' && $this['tipo_referencia'] == 'rango'){//0-10
        $rango = explode('-', $this['rango_referencia']);
        $rango[0] = 'Inferior a';
        return 'Inferior a ' . $rango[1];
      }

      if($this['rango_referencia'][strlen($this['rango_referencia']) - 1] == '∞' && $this['tipo_referencia'] == 'rango'){//10-x
        $rango = explode('-', $this['rango_referencia']);
        return 'Superior a ' . $rango[0];
      }

      if($this['tipo_referencia'] == 'reactiva' || $this['tipo_referencia'] == 'booleano'){//Reactiva  No reactiva
        return ucfirst(str_replace('_', ' ', $this['rango_referencia']));
      }

      if($this['rango_referencia'][0] == '0' && $this['tipo_referencia'] == 'rango_hasta'){//Hasta 10
        $rango = explode('-', $this['rango_referencia']);
        return 'Hasta ' . $rango[1];
      }
      if($this['tipo_referencia'] == 'rango_sexo'){
        $rango_tmp = explode('|', preg_replace("/[^0-9\-|.∞]/", "", $this['rango_referencia']));
        $rango = '';
        $r = explode('-', $rango_tmp[0]);
        if($r[0] == '0')
          $rango .= 'Fem. Inferior a ' . $r[1];
        else{
          if($r[1] == '∞')
            $rango .= 'Fem. superior a ' . $r[0];
          else
            $rango .= 'Fem. ' . $r[0] . ' - ' . $r[1];
        }
        $rango .= ' | ';
        $r = explode('-', $rango_tmp[1]);
        if($r[0] == '0')
          $rango .= 'Masc. Inferior a ' . $r[1];
        else{
          if($r[1] == '∞')
            $rango .= 'Masc. superior a ' . $r[0];
          else
            $rango .= 'Masc. ' . $r[0] . ' - ' . $r[1];
        }
        return $rango;
      }

      if($this['tipo_referencia'] == 'rango_edad'){
        $rango_tmp = explode('|', preg_replace("/[^0-9\-|.]/", "", $this['rango_referencia']));
        $rango = '';
        $r = explode('-', $rango_tmp[0]);
        if($r[0] == '0')
          $rango .= 'Niños Inferior a ' . $r[1];
        else
          if($r[1] == '∞')
            $rango .= 'Niños superior a ' . $r[0];
          else
            $rango .= 'Niños ' . $r[0] . ' - ' . $r[1];

        $rango .= ' | ';
        $r = explode('-', $rango_tmp[1]);
        if($r[0] == '0')
          $rango .= 'Adultos Inferior a ' . $r[1];
        else
          if($r[1] == '∞')
            $rango .= 'Adultos superior a ' . $r[0];
          else
            $rango .= 'Adultos ' . $r[0] . ' - ' . $r[1];

        return $rango;
      }
      return $this['rango_referencia'];
    }

    public function getHelperAttribute(){
      if($this['trato_especial'] && $this['tipo_trato'] == 'antibiograma'){
        $v = DB::select('select value from configuraciones where `key` = "antibiograma"')[0]->value;
        return explode(',', $v);
      }else{
        return '';
      }
    }



}
