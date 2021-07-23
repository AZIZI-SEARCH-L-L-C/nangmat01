<?php

namespace AziziSearchEngineStarter;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $table = 'notifications';

    protected $fillable = ['type', 'message', 'read'];
}
