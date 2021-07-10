<?php

namespace App\Command;

use App\Entity\NewsItem;
use App\Entity\ParseLog;
use App\Helper\UniCharDecoder;
use App\Http\RSSApiClient;
use App\Repository\NewsItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsCommand(
    name: 'app:rssapi:fetch',
    description: 'Add a short description for your command',
)]
class RSSApiFetchCommand extends Command
{
    private const BATCH_SIZE = 5;
    private int $i = 1;
    private EntityManagerInterface $entityManager;
    private RSSApiClient $rssApiClient;

    public function __construct(EntityManagerInterface $entityManager, RSSApiClient $rssApiClient)
    {
        $this->entityManager = $entityManager;
        $this->rssApiClient = $rssApiClient;

        parent::__construct();

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @noinspection PhpUnhandledExceptionInspection */
        $response = $this->rssApiClient->fetchRSS();
        /** @noinspection PhpUnhandledExceptionInspection */
        $fetchedBody = $response->getContent();
        $xml = simplexml_load_string($fetchedBody, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $newsList = json_decode($json, true);

        $parseLog = new ParseLog(
            new \DateTimeImmutable('now'),
            $response->getInfo()['http_method'],
            $response->getInfo()['url'],
            $response->getStatusCode(),
            $newsList
        );
        $this->entityManager->persist($parseLog);
        $this->entityManager->flush();

        /** @var NewsItemRepository $newsItemRepo */
        $newsItemRepo = $this->entityManager->getRepository(NewsItem::class);

        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        foreach ($newsList['channel']['item'] as $item){
            if(!$newsItemRepo->hasByGuid($item['guid'])){
                $newsItem = new NewsItem(
                    UniCharDecoder::decode($item['title']),
                    $item['link'],
                    UniCharDecoder::decode($item['description']),
                    $item['guid'],
                    new \DateTimeImmutable($item['pubDate']),
                    isset($item['author']) ? UniCharDecoder::decode($item['author']) : null,
                    $item['enclosure'] ?? null
                );
                $this->entityManager->persist($newsItem);
                if (($this->i % self::BATCH_SIZE) === 0) {
                    $this->entityManager->flush();
                    $this->entityManager->clear(); // Detaches all objects from Doctrine!
                }
                ++$this->i;
            }else {
                break;
            }
        }
        $this->entityManager->flush();
        $this->entityManager->clear();

        $io->success('Завршено успешно. В базу добавлено '. $this->i - 1 . ' нововстей');

        return Command::SUCCESS;
    }
}
