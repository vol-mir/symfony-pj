<?php

namespace App\Service\Parser;

use App\Service\Parser\Transport\TransportInterface;
use App\Service\Parser\NewsResource\RBCNewsFactory;

/**
 * Class News
 * @package App\Service\Parser
 */
class NewsFromUrl
{
    /** @var TransportInterface */
    private $transport;

    /**
     * Client constructor
     * @param TransportInterface $transport
     */
    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * The method returns news for RBC resource
     * @param  int $countNews
     * @return void
     */
    public function getRBCNews(int $countNews)
    {
        $rbc_url = "https://rssexport.rbc.ru/rbcnews/news/$countNews/full.rss";

        $xmlPage = $this->transport->get($rbc_url);

        $newsFactory = new RBCNewsFactory();
        $news = $newsFactory->createListNews();

        return $news->getListNews($xmlPage);
    }
}
