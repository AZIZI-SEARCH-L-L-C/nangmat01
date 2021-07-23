<?php

namespace AziziSearchEngineStarter;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class SimpleAds extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'title' => 10,
            'keywords' => 9,
            'description' => 8,
            'url' => 7,
            // 'Vurl' => 3,
        ]
    ];

    protected $table = 'simple_ads';

    protected $fillable = [
        'email',
        'title',
        'keywords',
        'description',
        'url',
        'Vurl',
        'turn',
    ];

}
