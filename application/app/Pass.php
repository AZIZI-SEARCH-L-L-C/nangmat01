<?php

namespace AziziSearchEngineStarter;

use Illuminate\Database\Eloquent\Model;

class Pass extends Model
{
    protected $table = 'password_resets';

    protected $fillable = ['email', 'token'];
}
