<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\NewsItem;
use Doctrine\DBAL\Types\GuidType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NewsItemTest extends DatabaseDependantTestCase
{

    /** @test */
    public function a_news_item_record_can_be_created_in_the_database()
    {
        $newsItem = new NewsItem(
            'News',
            'News description',
            '60e81a639a79475fee72acaf',
            new \DateTimeImmutable('Fri, 09 Jul 2021 10:45:21 +0300'),
            'Maks Barskih',
            ['https://1.img','https://2.img','https://3.img']
        );
        $newsItem->setTitle('News');
        $newsItem->setDescription('News description');

        $this->entityManager->persist($newsItem);

        $this->entityManager->flush();

        $newsItemRepo = $this->entityManager->getRepository(NewsItem::class);

        $newsItemRecord = $newsItemRepo->findOneBy(['title' => 'News']);

        $this->assertEquals('News', $newsItemRecord->getTitle());
        $this->assertEquals('News description', $newsItemRecord->getDescription());
        $this->assertEquals('60e81a639a79475fee72acaf', $newsItemRecord->getGuid());
        $this->assertEquals('Fri, 09 Jul 21 10:45:21 +0300', $newsItemRecord->getPubDate()->format("D, d M y H:i:s O"));
        $this->assertEquals('+03:00', $newsItemRecord->getPubDate()->getTimezone()->getName());

        $this->assertEquals('Maks Barskih', $newsItemRecord->getAuthor());
        $this->assertEquals(['https://1.img','https://2.img','https://3.img'], $newsItemRecord->getEnclosure());
    }
}