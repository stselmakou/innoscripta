<?php

namespace App\Services\Articles\Api\Retrievers;

use App\Services\Articles\Api\ArticleRetriever;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

/**
 *
 */
class NYTimes extends ArticleRetriever
{

    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @param $apiKey
     * @param $apiUrl
     */
    public function __construct(
        protected string $apiKey,
        protected string $apiUrl
    )
    {
        $this->client = new Client(['timeout' => 30]);
        parent::__construct($this->apiKey, $this->apiUrl);
    }

    /**
     * @param array $params
     * @return array
     */
    protected function request(array $params): array
    {
        try {
            $params['api-key'] = $this->apiKey;
            $response = $this->client->request(
                'GET',
                $this->apiUrl,
                ['query' => $params]
            );
        } catch (\Exception|GuzzleException|ClientException $e) {
            Log::stack(['single', 'errorlog'])->error($e->getMessage());
            return [];
        }
        $response = json_decode($response->getBody()->getContents(), true);
        return $response['response']['docs'] ?? [];
    }

    /**
     * @param $query
     * @return array
     */
    public function fetch($query): array
    {
        $params = ['page-size' => 50];
        return $this->request($params);
    }


}
