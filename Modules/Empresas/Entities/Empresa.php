<?php

namespace Modules\Empresas\Entities;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas__empresas';
    protected $fillable = ['nombre'];
}
