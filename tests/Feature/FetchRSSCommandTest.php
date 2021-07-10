<?php

declare(strict_types=1);


namespace App\Tests\Feature;


use App\Entity\NewsItem;
use App\Http\RSSApiClient;
use App\Tests\DatabaseDependantTestCase;
use App\Tests\DatabasePrimer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class FetchRSSCommandTest extends DatabaseDependantTestCase
{

    /** @test */
    public function the_fetch_rss_command_behaves_correctly()
    {
        $application = new Application(self::$kernel);
        $command = $application->find('app:rss:fetch');

        $commandTester = new CommandTester($command);

        $commandTester->execute([]);

        $newsItemRepo = $this->entityManager->getRepository(NewsItem::class);

        $rssApiClient = self::$kernel->getContainer()->get('rss-api-client');
        $xml = simplexml_load_string($rssApiClient->fetchRSS()->getContent(), "SimpleXMLElement", LIBXML_NOCDATA);
        $newsItem = json_decode(json_encode($xml), true)['channel']['item']['0'];

        $newsItemRecord = $newsItemRepo->findOneBy(['guid' => $newsItem['guid']]);
        $date = new \DateTimeImmutable($newsItem['pubDate']);

        $this->assertEquals($newsItem['title'], $newsItemRecord->getTitle());
        $this->assertEquals($newsItem['link'], $newsItemRecord->getLink());
        $this->assertEquals($newsItem['description'], $newsItemRecord->getDescription());
        $this->assertEquals($newsItem['guid'], $newsItemRecord->getGuid());
        $this->assertEquals($date->format("D, d M y H:i:s O"), $newsItemRecord->getPubDate()->format("D, d M y H:i:s O"));
        $this->assertEquals($date->getTimezone()->getName(), $newsItemRecord->getPubDate()->getTimezone()->getName());

        $this->assertEquals($newsItem['author'] ?? '', $newsItemRecord->getAuthor());
        $this->assertEquals($newsItem['enclosure'] ?? '', $newsItemRecord->getEnclosure());
        $this->assertEquals(true, $newsItemRecord->getLast());
    }

    /** @test */
    public function the_fetch_rss_command_write_log_correctly()
    {
        $application = new Application(self::$kernel);
        $command = $application->find('app:rss:fetch');

        $commandTester = new CommandTester($command);

        $commandTester->execute([]);

        $parseLogRepo = $this->entityManager->getRepository(NewsItem::class);
        $parseLogRecord = $parseLogRepo->findOneBy(['$responseHTTPCode' => 200]);

        $this->assertEquals('GET', $parseLogRecord->getRequestMethod());
        $this->assertEquals('http://static.feed.rbc.ru/rbc/logical/footer/news.rss', $parseLogRecord->getRequestURL());
        $this->assertEquals(200, $parseLogRecord->getResponseHTTPCode());
        $this->assertArrayHasKey('channel', $parseLogRecord->getResponseBody());
    }
}