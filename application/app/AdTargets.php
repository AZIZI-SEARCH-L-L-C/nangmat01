<?php

namespace AziziSearchEngineStarter;

use Illuminate\Database\Eloquent\Model;

class AdTargets extends Model
{
    protected $table = 'ad_targets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'type', 
		'show_in', 
		'continent', 
		'inc_countries', 
		'exc_countries', 
		'Interests', 
		'gender', 
		'age', 
		'language',
		'strict',
		'byBudget',
		'budget',
		'start',
		'end',
		'ad_id',
	];
	
}