<?php

namespace AziziSearchEngineStarter;

use Illuminate\Database\Eloquent\Model;

class Sites extends Model
{
    protected $table = 'local_sites';

    protected $fillable = [
        'title',
        'description',
        'url',
        'Vrl',
        'type',
        'enabled',
        'approved',
        'page',
        'rank',
        'user_id',
    ];

    public function keyword(){
        return $this->belongsTo('AziziSearchEngineStarter\Keywords', 'keyword_id');
    }
}
