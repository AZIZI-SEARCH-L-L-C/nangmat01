<?php

namespace AziziSearchEngineStarter;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    
	protected $table = 'ads_payments';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id', 
		'payment_id', 
		'method', 
		'transactions', 
		'total', 
	];
	
	public function ad(){
		return $this->hasOne('AziziSearchEngineStarter\Advertisements', 'id', 'ads_id');
	}
}
