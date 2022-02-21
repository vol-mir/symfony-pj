<?php

namespace App\Service\Parser;

use App\Entity\News;
use App\Helper\DateHelper;
use App\Helper\StringHelper;
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
        $countAddNews = $this->addNewsDB($news->getListNews($xmlPage));

        return $countAddNews;
    }

    /**
     * Add news DB
     * @param  array $listNews
     * @return int
     */
    public function addNewsDB($listNews)
    {
        if (count($listNews) === 0 || !is_array($listNews["channel"])) {
            return 0;
        }
        $channel = $listNews["channel"];

        if (!is_array($channel["item"])) {
            return 0;
        }
        $items = $channel["item"];

        $entityManager = $this->doctrine->getManager();
        $countAddNews = 0;

        foreach ($items as $item) {
            if ($entityManager->getRepository(News::class)->getCountRecordsForInnerId($item["news_id"]) > 0) {
                continue;
            }

            $news = new News();
            $news->setNewsId(StringHelper::getElemStrArr($item, "news_id"));
            $news->setTitle(StringHelper::getElemStrArr($item, "title"));
            $news->setLink(StringHelper::getElemStrArr($item, "link"));
            $news->setDateNews(
                DateHelper::parseFromInt($item["newsDate_timestamp"])
            );

            $news->setFullText(StringHelper::getElemStrArr($item, "full-text"));

            $news->setCategory(StringHelper::getElemStrArr($item, "category"));
            $news->setAuthor(StringHelper::getElemStrArr($item, "author"));

            if (array_key_exists("image", $item) && is_array($item["image"])) {
                $images = $item["image"];

                $imagePath = null;
                if (array_key_exists("url", $images)) {
                    $imagePath = $images["url"];
                } elseif (array_key_exists(0, $images) && array_key_exists("url", $images[0])) {
                    $imagePath = $images[0]["url"];
                }

                $news->setImage($imagePath);
            }

            $entityManager->persist($news);
            $countAddNews++;
        }
        $entityManager->flush();

        return $countAddNews;
    }
}
