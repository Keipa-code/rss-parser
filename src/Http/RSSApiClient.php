<?php

declare(strict_types=1);

namespace App\Http;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class RSSApiClient
{
    private HttpClientInterface $httpClient;

    private const URL = 'http://static.feed.rbc.ru/rbc/logical/footer/news.rss';

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function fetchRSS(): ResponseInterface
    {
        return $this->httpClient->request('GET', self::URL, [
           'headers' => [
               'user-agent' => 'FeedFetcher-Google',
               'accept' => '*/*',
           ]
        ]);
    }
}