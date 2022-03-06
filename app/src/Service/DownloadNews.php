<?php

namespace App\Service;

use App\Service\Parser\Resource\RBCWebResource;
use App\Service\Storage\DoctrineStorage;
use App\Service\Parser\Transport;
use App\Service\Parser\Transport\TransportInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class News
 * @package App\Service
 */
class DownloadNews
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
     * The method returns count add news for RBC resource
     * @param int $countNews
     * @return int
     * @throws Transport\NotFoundException
     * @throws Transport\TransportException
     */
    public function downloadRBCNews(int $countNews = 15)
    {
        $countAddNews = 0;
        $url = "https://rssexport.rbc.ru/rbcnews/news/$countNews/full.rss";
        $xmlPage = $this->transport->get($url);

        if (!$xmlPage) {
            return $countAddNews;
        }

        $rbcResource = new RBCWebResource();
        $rbcListNews = $rbcResource->createListNews();
        $arrNews = $rbcListNews->getListNews($xmlPage);

        if (is_array($arrNews)) {
            $doctrineStorage = new DoctrineStorage();
            $doctrineActions = $doctrineStorage->createStorage($this->doctrine);
            $countAddNews = $doctrineActions->saveListNews($arrNews);
        }

        return $countAddNews;
    }

}
