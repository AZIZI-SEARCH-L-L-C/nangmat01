<?php

namespace AziziSearchEngineStarter;

use Illuminate\Database\Eloquent\Model;

class Keywords extends Model
{

    protected $fillable = [
        'keyword',
        'user_id',
    ];

    public function sites(){
        return $this->hasMany('AziziSearchEngineStarter\Sites', 'keyword_id');
    }

    public function user(){
        return $this->belongsTo('AziziSearchEngineStarter\User', 'user_id');
    }
}
