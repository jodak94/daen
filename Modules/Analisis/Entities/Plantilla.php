<?php

namespace Modules\Analisis\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Plantilla extends Model
{

    protected $table = 'analisis__plantillas';
    public $translatedAttributes = [];
    protected $fillable = [];
}
