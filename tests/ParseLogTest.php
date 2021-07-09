<?php

declare(strict_types=1);


namespace App\Tests;


use App\Entity\ParseLog;

final class ParseLogTest extends DatabaseDependantTestCase
{
    /** @test */
    public function a_parse_log_record_can_be_created_in_the_database()
    {
        $parseLog = new ParseLog(
            $date   = new \DateTimeImmutable("now"),
            $method = 'GET',
            $url    = 'https://rss-url.com',
            $code   = 200,
            $body   = ['1', 'array' => ['2', '3']]
        );

        $this->entityManager->persist($parseLog);

        $this->entityManager->flush();

        $parseLogRepo = $this->entityManager->getRepository(ParseLog::class);

        $parseLogRecord = $parseLogRepo->findOneBy(['requestURL' => 'https://rss-url.com']);

        $this->assertEquals($date->format("D, d M y H:i:s O"), $parseLogRecord->getDate()->format("D, d M y H:i:s O"));
        $this->assertEquals($method, $parseLogRecord->getRequestMethod());
        $this->assertEquals($url, $parseLogRecord->getRequestURL());
        $this->assertEquals($code, $parseLogRecord->getResponseHTTPCode());
        $this->assertEquals($body, $parseLogRecord->getResponseBody());
    }
}