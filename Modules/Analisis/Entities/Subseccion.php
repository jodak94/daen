<?php

namespace Modules\Analisis\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Subseccion extends Model
{
    protected $table = 'analisis__subseccions';
    public $translatedAttributes = [];
    protected $fillable = ['titulo', 'seccion_id'];

    public function seccion(){
      return $this->belongsTo('Modules\Analisis\Entities\Seccion');
    }

    public function determinacion(){
      return $this->hasMany('Modules\Analisis\Entities\Determinacion');
    }
}
