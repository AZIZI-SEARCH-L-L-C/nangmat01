<?php

namespace AziziSearchEngineStarter;

use Illuminate\Database\Eloquent\Model;

class AdsCompain extends Model
{
    protected $table = 'ads_compains';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
	
	public function user(){
		return $this->belongsTo('AziziSearchEngineStarter\User', 'user_id');
	}
	
	public function ads(){
		return $this->hasMany('AziziSearchEngineStarter\Advertisements', 'compain_id');
	}
	
    protected static function boot() {
        parent::boot();

        static::deleting(function($compain) {
            foreach($compain->ads()->get() as $ad){
                $ad->delete();
            }
        });
    }
}
