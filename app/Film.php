<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ScoutElastic\Searchable;

class Film extends Model
{
    use Searchable;

    /**
     * @var string
     */
    protected $indexConfigurator = FilmsIndexConfigurator::class;

    /**
     * @var array
     */
    protected $searchRules = [
        MySearchRule::class
    ];

    /**
     * @var array
     */
    protected $mapping = [
        'properties' => [
            'title' => [
                'type' => 'text',
                'fields' => [
                    'keywordstring'=> [
                        'type'=> 'text',
                        'analyzer'=> 'keyword_analyzer'
                    ],
                    'edgengram' => [
                        'type' => 'text',
                        'analyzer' => 'edge_ngram_analyzer',
                        'search_analyzer' => 'edge_ngram_search_analyzer'
                    ],
                    'trigram' => [
                        'type' => 'text',
                        'analyzer' => 'trigram'
                    ],
                    'completion' => [
                        'type' => 'completion'
                    ]
                ]
            ],
            'description' => [
                'type' => 'text'
            ]
        ]
    ];

    protected $table = 'film';

    protected $primaryKey = 'film_id';

    public $timestamps = false;

    public function actors() {
        return $this->belongsToMany(Actor::class, 'film_actor', 'film_id', 'actor_id');
    }
}
