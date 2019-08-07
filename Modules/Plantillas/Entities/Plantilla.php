<?php

namespace Modules\Plantillas\Entities;

use Illuminate\Database\Eloquent\Model;

class Plantilla extends Model
{

    protected $table = 'plantillas__plantillas';
    protected $fillable = [];

    public function detalles(){
      return $this->hasMany('Modules\Plantillas\Entities\PlantillaDetalle');
    }
}
