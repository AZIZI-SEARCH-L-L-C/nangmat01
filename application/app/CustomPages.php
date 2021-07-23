<?php

namespace AziziSearchEngineStarter;

use Illuminate\Database\Eloquent\Model;

class CustomPages extends Model
{
    protected $table = 'custompages';

    protected $fillable = ['title', 'slug', 'body'];
}
