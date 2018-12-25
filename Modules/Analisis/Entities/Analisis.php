<?php

namespace Modules\Analisis\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Analisis extends Model
{

    protected $table = 'analisis__analises';
    public $translatedAttributes = [];
    protected $fillable = [];
}
