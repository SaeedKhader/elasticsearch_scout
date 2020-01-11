<?php

namespace App;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class FilmsIndexConfigurator extends IndexConfigurator
{

    use Migratable;

    protected $name = 'films';

    /**
     * @var array
     */
    protected $settings = [
        'analysis' => [
            'tokenizer' => [
                'edge_ngram_tokenizer' => [
                    'type' => 'edge_ngram',
                    'min_gram' => 2,
                    'max_gram' => 5,
                    'token_chars' => [
                        'letter'
                    ]
                ]
            ],
            'filter' => [
                'autocomplete_filter' => [
                    'type' => 'edge_ngram',
                    'min_gram' => 1,
                    'max_gram' => 20
                ],
                'shingle' => [
                    'type' => 'shingle',
                    'min_shingle_size' => 2,
                    'max_shingle_size' => 4
                ]
            ],
            'analyzer' => [
                'keyword_analyzer' => [
                    'type' => 'custom',
                    'tokenizer' => 'keyword',
                    'filter'=> [
                        'lowercase',
                        'asciifolding',
                        'trim'
                    ],
                    'char_filter' => []
                ],
                'edge_ngram_analyzer'=> [
                    'filter' => [
                        'lowercase'
                    ],
                    'tokenizer' => 'edge_ngram_tokenizer'
                ],
                'edge_ngram_search_analyzer'=> [
                    'tokenizer'=> 'lowercase'
                ],
                'autocomplete' => [
                    'type' => 'custom',
                    'tokenizer' => 'standard',
                    'filter' => [
                        'lowercase',
                        'autocomplete_filter'
                    ]
                ],
                'trigram' => [
                    'type' => 'custom',
                    'tokenizer' => 'standard',
                    'filter' => [
                        'lowercase',
                        'shingle'
                    ]
                ]
            ]
        ]
    ];
}
