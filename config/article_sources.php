<?php

return [
    'news_api' => [
        'retriever'   => \App\Services\Articles\Api\Retrievers\NewsApi::class,
        'processor'   => \App\Jobs\Processors\NewsApi::class,
        'api_key' => env('NEWSAPI_API_KEY'),
        'api_url' => env('NEWSAPI_URL', 'https://newsapi.org/v2/everything'),
    ],
    'the_guardian' => [
        'retriever'   => App\Services\Articles\Api\Retrievers\TheGuardian::class,
        'processor'   => \App\Jobs\Processors\TheGuardian::class,
        'api_key' => env('THEGUARDIAN_API_KEY'),
        'api_url' => env('THEGUARDIAN_URL', 'https://content.guardianapis.com/search'),
    ],
    'ny_times' => [
        'retriever'   => App\Services\Articles\Api\Retrievers\NYTimes::class,
        'processor'   => \App\Jobs\Processors\NYTimes::class,
        'api_key' => env('NYTIMES_API_KEY'),
        'api_url' => env('NYTIMES_URL', 'https://api.nytimes.com/svc/search/v2/articlesearch.json'),
    ],
];
