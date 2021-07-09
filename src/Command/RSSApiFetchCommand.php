<?php

namespace App\Command;

use App\Entity\NewsItem;
use App\Http\RSSApiClient;
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
        $xml = simplexml_load_string($fetchedBody);

        $newsList = $xml->xpath('//item');

        foreach ($newsList as $item){
            dd($item->title->__toString());
            //$newsItem = new NewsItem();
        }


        $this->entityManager->persist($newsItem);

        $this->entityManager->flush();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
