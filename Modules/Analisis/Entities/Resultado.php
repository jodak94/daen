<?php

namespace Modules\Analisis\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
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
        return str_replace(".0", "", (string)number_format($this->attributes['valor'], 1));  
      }

      return $this->attributes['valor'];
    }
}
