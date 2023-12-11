<?php

namespace App\Services\Articles\Api;


abstract class ArticleRetriever
{
    public function __construct(
        protected string $apiKey,
        protected string $apiUrl
    )
    {

    }

    abstract protected function request(array $params): array;

    abstract public function fetch($query): array;


}
