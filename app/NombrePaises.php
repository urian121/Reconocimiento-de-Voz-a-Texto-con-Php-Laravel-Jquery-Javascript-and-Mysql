<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NombrePaises extends Model
{
    protected $table = 'nombre_paises';
    protected $guarded = array('speechToText');
}
