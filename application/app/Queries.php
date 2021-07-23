<?php

namespace AziziSearchEngineStarter;

use Illuminate\Database\Eloquent\Model;

class Queries extends Model
{
    protected $table = 'queries';
	
	protected $fillable = ['query', 'country', 'browser', 'device', 'os'];
}
