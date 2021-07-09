<?php

declare(strict_types=1);

namespace App\Http;

use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class RSSApiClient
{
    private HttpClientInterface $httpClient;

    private const URL = 'http://static.feed.rbc.ru/rbc/logical/footer/news.rss';
    private const METHOD = 'GET';

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function fetchRSS(): ResponseInterface
    {
        $response = $this->httpClient->request(self::METHOD, self::URL, [
           'headers' => [
               'user-agent' => 'FeedFetcher-Google',
               'accept' => '*/*',
           ]
        ]);

        if($response->getStatusCode() !== 200) {
            throw new TransportException();
        }

        return $response;
    }

}