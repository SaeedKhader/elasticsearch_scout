<?php

namespace App;

use ScoutElastic\SearchRule;

class MySearchRule extends SearchRule
{
    /**
     * @inheritdoc
     */
    public function buildHighlightPayload()
    {
        return [
            'number_of_fragments' => 3,
            'fragment_size' => 150,
            'fields' => [
                'title' => [ 'pre_tags' => ['<b class="highlight">'], 'post_tags' => ['</b>'] ],
                'description' => [ 'pre_tags' => ['<b class="highlight">'], 'post_tags' => ['</b>'] ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function buildQueryPayload()
    {
        $query = $this->builder->query;

        return [
            'should' => [
                [
                    'match' => [
                        'title' => [
                            'query' => $query,
                            'boost' => 3
                        ]
                    ]
                ],
                [
                    'match' => [
                        'description' => [
                            'query' => $query,
                            'boost' => 2
                        ]
                    ]
                ]
            ]
        ];
    }
}
