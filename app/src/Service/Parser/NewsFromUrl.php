<?php

namespace App\Service\Parser;

use App\Service\Parser\Transport\TransportInterface;
use App\Service\Parser\NewsResource\RBCNewsFactory;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class News
 * @package App\Service\Parser
 */
class NewsFromUrl
{
    /** @var TransportInterface */
    private $transport;

    /** @var ManagerRegistry */
    private $doctrine;

    /**
     * Client constructor
     * @param TransportInterface $transport
     * @param ManagerRegistry $doctrine
     */
    public function __construct(
        TransportInterface $transport,
        ManagerRegistry $doctrine
    ) {
        $this->transport = $transport;
        $this->doctrine = $doctrine;
    }

    /**
     * The method returns news for RBC resource
     * @param  int $countNews
     * @return int
     */
    public function getRBCNews(int $countNews)
    {
        $countAddNews = 0;
        $rbc_url = "https://rssexport.rbc.ru/rbcnews/news/$countNews/full.rss";

        $xmlPage = $this->transport->get($rbc_url);

        if (!$xmlPage) {
            return $countAddNews;
        }

        $newsFactory = new RBCNewsFactory();
        $news = $newsFactory->createListNews();
        
        $arrNews = $news->getListNews($xmlPage);
        if (is_array($arrNews)) {
            $countAddNews = $news->addNewsDB($this->doctrine, $arrNews);
        }
        
        return $countAddNews;
    }

}
