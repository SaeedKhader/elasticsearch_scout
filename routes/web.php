<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\MySearchRule;
use Elasticsearch\ClientBuilder;

Route::get('/', function () {
    return view('films.index', [
        'films' => App\Film::all(),
        'query' => ''
    ]);
});

Route::get('/search', function () {
    if ( request('q') == '' ) {
        return redirect('/');
    }
    $films =  App\Film::search(request('q'))->get();
    return view('films.index', [
        'films' => $films,
        'query' => request('q')
    ]);
});

Route::get('/search/completions/{query}', function ($query) {
    $keywordstring = [
        'index' => 'test_auto_c',
        'body' => [
            'query' => [
                'prefix' => [
                    'title.keywordstring' => request('q')
                ]
            ]
        ]
    ];
    $edgengram = [
        'index' => 'test_auto_c',
        'body' => [
            'query' => [
                'match' => [
                    'title.edgengram' => request('q')
                ]
            ]
        ]
    ];
    $phraseSuggester = [
        'index' => 'test_auto_c',
        'body' => [
            'suggest'=> [
                'text'=> request('q'),
                'simple_phrase'=> [
                    'phrase' => [
                        'field'=> 'title.trigram',
                        'size'=> 1,
                        'gram_size'=> 3,
                        'direct_generator'=> [
                            [
                                'field'=> 'title.trigram',
                                'suggest_mode'=> 'always'
                            ]
                        ],
                        'highlight'=> [
                            'pre_tag'=> '<em>',
                            'post_tag'=> '</em>'
                        ]
                    ]
                ]
            ]
        ]
    ];
    $completion = [
        'index' => 'films',
        'body' => [
            'suggest'=> [
                'simple_phrase'=> [
                    'prefix' => $query,
                    'completion' => [
                        'field'=> 'title.completion',
                        'fuzzy'=> [
                            'fuzziness' => 1
                        ]
                    ]
                ]
            ]
        ]
    ];
    $client = ClientBuilder::create()->build();
    $response = $client->search($completion);
    $final = $response['suggest']['simple_phrase'][0]['options'];
    logger(response()->json($final, 200));
    return response()->json($final, 200);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
