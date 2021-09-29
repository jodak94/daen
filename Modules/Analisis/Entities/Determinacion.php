<?php

namespace Modules\Analisis\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Log;
use DB;
use Carbon\Carbon;
class Determinacion extends Model
{

    protected $table = 'analisis__determinacions';
    public $translatedAttributes = [];
    protected $fillable = ['tipo_referencia', 'titulo', 'rango_referencia', 'unidad_medida', 'subseccion_id', 'orden', 'multiples_lineas', 'trato_especial', 'tipo_trato', 'texto_ref', 'texto_h', 'texto_por_defecto'];
    protected $appends = ['rango_referencia_format', 'helper'];

    public static $tipos_refs = [
      'rango' => 'Rango',
      'rango_edad' => 'Rango considerando edad (Adultos / Niños)',
      'rango_sexo' => 'Rango considerando sexo',
      'booleano' => 'Positivo / Negativo',
      'reactiva' => 'Reactivo / No Reactivo',
      'no_aglutina_dil_1:20' => 'No aglutina dil 1:20',
      'negativo_dil_1:20' => 'Negativo dil 1:20',
      'clase_o' => 'Clase "O"',
      'sin_referencia' => '--'
    ];

    public static $tipos_tratos = [
      null => '--',
      'antibiograma' => 'Antibiograma',
      'select' => 'Selección',
      'multi_select' => 'Multi Selección',
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
        return 'Inferior a ' . number_format($rango[1]);
      }

      if($this['rango_referencia'][strlen($this['rango_referencia']) - 1] == '∞' && $this['tipo_referencia'] == 'rango'){//10-x
        $rango = explode('-', $this['rango_referencia']);
        return 'Superior a ' . number_format($rango[0]);
      }


      // if($this['tipo_referencia'] == 'rango'){
      //   $r = explode('-', $this['rango_referencia']);
      //   return number_format($r[0]) . ' - ' . number_format($r[1]);
      // }

      if($this['tipo_referencia'] == 'reactiva' || $this['tipo_referencia'] == 'booleano' || $this['tipo_referencia'] == 'no_aglutina_dil_1:20' || $this['tipo_referencia'] == 'negativo_dil_1:20' || $this['tipo_referencia'] == 'clase_"o"'){//Reactiva  No reactiva
        return ucfirst(str_replace('_', ' ', $this['rango_referencia']));
      }

      if($this['tipo_referencia'] == 'clase_o'){//Reactiva  No reactiva
        return 'Clase "O"';
      }

      if($this['rango_referencia'][0] == '0' && $this['tipo_referencia'] == 'rango_hasta'){//Hasta 10
        $rango = explode('-', $this['rango_referencia']);
        return 'Hasta ' . number_format($rango[1]);
      }
      if($this['tipo_referencia'] == 'rango_sexo'){
        $rango_tmp = explode('|', preg_replace("/[^0-9\-|.∞]/", "", $this['rango_referencia']));
        $rango = '';
        $r = explode('-', $rango_tmp[0]);
        if($r[0] == '0')
          $rango .= 'Fem. Inferior a ' . number_format($r[1]);
        else{
          if($r[1] == '∞')
            $rango .= 'Fem. superior a ' . number_format($r[0]);
          else
            $rango .= 'Fem. ' . number_format($r[0]) . ' - ' . number_format($r[1]);
        }
        $rango .= ' | ';
        $r = explode('-', $rango_tmp[1]);
        if($r[0] == '0')
          $rango .= 'Masc. Inferior a ' . number_format($r[1]);
        else{
          if($r[1] == '∞')
            $rango .= 'Masc. superior a ' . number_format($r[0]);
          else
            $rango .= 'Masc. ' . number_format($r[0]) . ' - ' . number_format($r[1]);
        }
        return $rango;
      }

      if($this['tipo_referencia'] == 'rango_edad'){
        $rango_tmp = explode('|', preg_replace("/[^0-9\-|.]/", "", $this['rango_referencia']));
        $rango = '';
        $r = explode('-', $rango_tmp[0]);
        if($r[0] == '0')
          $rango .= 'Niños Inferior a ' . number_format($r[1]);
        else
          if($r[1] == '∞')
            $rango .= 'Niños superior a ' . number_format($r[0]);
          else
            $rango .= 'Niños ' . number_format($r[0]) . ' - ' . number_format($r[1]);

        $rango .= ' | ';
        $r = explode('-', $rango_tmp[1]);
        if($r[0] == '0')
          $rango .= 'Adultos Inferior a ' . number_format($r[1]);
        else
          if($r[1] == '∞')
            $rango .= 'Adultos superior a ' . number_format($r[0]);
          else
            $rango .= 'Adultos ' . number_format($r[0]) . ' - ' . number_format($r[1]);

        return $rango;
      }


      return $this['rango_referencia'];
    }

    public function getRangoReferenciaFormatAttributeSexoEdad($paciente){
      if($this['tipo_referencia'] == 'rango_sexo'){
        if($paciente->sexo == 'femenino'){
          $rango = substr($this['rango_referencia_format'], 0, strpos($this['rango_referencia_format'], '|'));
          return $rango;
        }else{
          $rango = substr($this['rango_referencia_format'], strpos($this['rango_referencia_format'], '|') + 1, strlen($this['rango_referencia_format']));
          return $rango;
        }
      }
      if($this['tipo_referencia'] == 'rango_edad'){
        $age = Carbon::parse($paciente->fecha_nacimiento)->age;
        if($age < 15){
          $rango = substr($this['rango_referencia_format'], 0, strpos($this['rango_referencia_format'], '|'));
          return $rango;
        }else{
          $rango = substr($this['rango_referencia_format'], strpos($this['rango_referencia_format'], '|') + 1, strlen($this['rango_referencia_format']));
          return $rango;
        }
      }
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
