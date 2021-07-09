<?php

declare(strict_types=1);


namespace App\Tests\Feature;


use App\Entity\NewsItem;
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

        $newsItemRecord = $newsItemRepo->findOneBy(['title' => 'News']);

        $this->assertEquals('News', $newsItemRecord->getTitle());
        $this->assertEquals('News description', $newsItemRecord->getDescription());

        $this->assertEquals('Fri, 09 Jul 21 10:45:21 +0300', $newsItemRecord->getPubDate()->format("D, d M y H:i:s O"));
        $this->assertEquals('+03:00', $newsItemRecord->getPubDate()->getTimezone()->getName());

        $this->assertEquals('Maks Barskih', $newsItemRecord->getAuthor());
        $this->assertEquals(['https://1.img','https://2.img','https://3.img'], $newsItemRecord->getImage());
    }
}