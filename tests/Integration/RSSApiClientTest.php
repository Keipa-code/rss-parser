<?php

declare(strict_types=1);


namespace App\Tests\Integration;


use App\Tests\DatabaseDependantTestCase;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @test
 * @group integration
 */
class RSSApiClientTest extends DatabaseDependantTestCase
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @test
     */
    public function the_rss_api_client_returns_correct_data()
    {
        $rssApiClient = self::$kernel->getContainer()->get('rss-api-client');

        /** @var ResponseInterface $response */
        $response = $rssApiClient->fetchRSS();
        $xml = simplexml_load_string($response->getContent());

        $this->assertSame('https://www.rbc.ru/', $xml->channel->link->__toString());
        $this->assertSame('rss.rbc.ru', $xml->channel->description->__toString());
    }
}