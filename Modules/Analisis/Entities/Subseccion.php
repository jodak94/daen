<?php

namespace Modules\Analisis\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Subseccion extends Model
{
    use Translatable;

    protected $table = 'analisis__subseccions';
    public $translatedAttributes = [];
    protected $fillable = [];
}
