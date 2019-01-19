<?php

namespace Modules\Analisis\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use Translatable;

    protected $table = 'analisis__seccions';
    public $translatedAttributes = [];
    protected $fillable = [];
}
