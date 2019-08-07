<?php

namespace Modules\Plantillas\Entities;

use Illuminate\Database\Eloquent\Model;

class PlantillaDetalle extends Model
{

    protected $table = 'plantillas__plantilladetalles';
    protected $fillable = [];

    public function determinacion(){
      return $this->belongsTo('Modules\Analisis\Entities\Determinacion');
    }
}
