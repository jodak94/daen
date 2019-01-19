<?php

namespace Modules\Analisis\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Determinacion extends Model
{
    use Translatable;

    protected $table = 'analisis__determinacions';
    public $translatedAttributes = [];
    protected $fillable = [];
}
