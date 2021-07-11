<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\NewsItem;

class NewsItemTest extends DatabaseDependantTestCase
{

    /** @test */
    public function a_news_item_record_can_be_created_in_the_database()
    {
        $newsItem = new NewsItem();

        $newsItem->setTitle('News');
        $newsItem->setLink('https://link.com');
        $newsItem->setDescription('News description');
        $newsItem->setGuid('60e81a639a79475fee72acaf');
        $newsItem->setPubDate('Fri, 09 Jul 2021 10:45:21 +0300');
        $newsItem->setAuthor('Maks Barskih');
        $newsItem->setEnclosure(['https://1.img','https://2.img','https://3.img']);

        $this->entityManager->persist($newsItem);

        $this->entityManager->flush();

        $newsItemRepo = $this->entityManager->getRepository(NewsItem::class);

        $newsItemRecord = $newsItemRepo->findOneBy(['title' => 'News']);

        $this->assertEquals('News', $newsItemRecord->getTitle());
        $this->assertEquals('https://link.com', $newsItemRecord->getLink());
        $this->assertEquals('News description', $newsItemRecord->getDescription());
        $this->assertEquals('60e81a639a79475fee72acaf', $newsItemRecord->getGuid());
        $this->assertEquals('Fri, 09 Jul 21 10:45:21 +0300', $newsItemRecord->getPubDate()->format("D, d M y H:i:s O"));
        $this->assertEquals('+03:00', $newsItemRecord->getPubDate()->getTimezone()->getName());
        $this->assertEquals('Maks Barskih', $newsItemRecord->getAuthor());
        $this->assertEquals(['https://1.img','https://2.img','https://3.img'], $newsItemRecord->getEnclosure());
    }
}