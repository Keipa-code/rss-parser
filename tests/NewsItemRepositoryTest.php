<?php

declare(strict_types=1);


namespace App\Tests;


use App\Entity\NewsItem;

final class NewsItemRepositoryTest extends DatabaseDependantTestCase
{
    /** @test */
    public function the_has_by_guid_method_behaves_correctly()
    {
        $newsItem = new NewsItem();
        $newsItem->setTitle('News');
        $newsItem->setLink('https://link.com');
        $newsItem->setDescription('News description');
        $newsItem->setGuid('99e81a639a79475fee72acaf');
        $newsItem->setPubDate('Fri, 09 Jul 2021 10:45:21 +0300');
        $newsItem->setAuthor('Maks Barskih');
        $newsItem->setEnclosure(['https://1.img','https://2.img','https://3.img']);

        $this->entityManager->persist($newsItem);

        $this->entityManager->flush();

        $newsItemRepo = $this->entityManager->getRepository(NewsItem::class);

        $boolean = $newsItemRepo->hasByGuid('99e81a639a79475fee72acaf');

        $this->assertEquals(true, $boolean);
    }

    /** @test */
    public function the_has_by_guid_method_return_false()
    {
        $newsItem = new NewsItem();
        $newsItem->setTitle('News');
        $newsItem->setLink('https://link.com');
        $newsItem->setDescription('News description');
        $newsItem->setGuid('99e81a639a79475fee72acaf');
        $newsItem->setPubDate('Fri, 09 Jul 2021 10:45:21 +0300');
        $newsItem->setAuthor('Maks Barskih');
        $newsItem->setEnclosure(['https://1.img','https://2.img','https://3.img']);

        $this->entityManager->persist($newsItem);

        $this->entityManager->flush();

        $newsItemRepo = $this->entityManager->getRepository(NewsItem::class);

        $boolean = $newsItemRepo->hasByGuid('incorrect_guid');

        $this->assertEquals(false, $boolean);
    }
}