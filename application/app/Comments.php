<?php

namespace AziziSearchEngineStarter;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = 'comments';

    public function user(){
        return $this->belongsTo('AziziSearchEngineStarter\User', 'user_id');
    }

    public function engine(){
        return $this->belongsTo('AziziSearchEngineStarter\Engines', 'engine_id');
    }

    public function replies(){
        return $this->hasMany('AziziSearchEngineStarter\Comments', 'comment_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
