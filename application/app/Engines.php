<?php

namespace AziziSearchEngineStarter;

use Illuminate\Database\Eloquent\Model;

class Engines extends Model
{
    protected $table = 'engines';

    protected $fillable = ['name', 'order', 'controller', 'turn', 'key'];
}
