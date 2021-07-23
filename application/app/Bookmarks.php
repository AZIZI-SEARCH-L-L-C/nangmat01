<?php

namespace AziziSearchEngineStarter;

use Illuminate\Database\Eloquent\Model;

class Bookmarks extends Model
{

    protected $table = 'bookmarks';

    public function user(){
        return $this->belongsTo('AziziSearchEngineStarter\User', 'user_id');
    }

    public function category(){
        return $this->belongsTo('AziziSearchEngineStarter\BookmarksCats', 'category_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function scopeCatOrdered($query)
    {
        return $query->orderBy('order_cat', 'asc');
    }

    public function scopeSubCatOrdered($query)
    {
        return $query->orderBy('order_sub_cat', 'asc');
    }
}
