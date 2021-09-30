<?php

namespace Modules\Analisis\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Log;
class Resultado extends Model
{
    protected $table = 'analisis__resultados';
    public $translatedAttributes = [];
    protected $fillable = [];

    public function determinacion(){
      return $this->belongsTo('Modules\Analisis\Entities\Determinacion');
    }

    public function getValorAttribute(){
      if(is_numeric($this->attributes['valor'])){
        $dec = 1;
        $remove = ".0";
        if($this->determinacion->cantidad_decimales == 2){
          $remove = "";
        }

        return str_replace($remove, "", (string)number_format($this->attributes['valor'], $this->determinacion->cantidad_decimales));
      }

      return $this->attributes['valor'];
    }
}
