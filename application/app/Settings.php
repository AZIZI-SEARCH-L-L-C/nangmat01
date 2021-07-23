<?php

namespace AziziSearchEngineStarter;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';

    protected $fillable = ['name', 'value'];
}
