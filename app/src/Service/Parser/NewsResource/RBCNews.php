<?php

namespace App\Service\Parser\NewsResource;

use App\Entity\News;
use App\Helper\DateHelper;
use App\Helper\StringHelper;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class RBCNews
 * @package App\Service\Parser\NewsResource
 */
class RBCNews implements NewsList
{
    /**
     * Get list news
     * @param  string $xmlPage
     * @return array|null
     */    
    public function getListNews(string $xmlPage)
    {
        try {
            $xmlPage = preg_replace("/rbc_news:/", "", $xmlPage);
            $xml = simplexml_load_string($xmlPage);
            $json = json_encode($xml);
            $array = json_decode($json, true);
        } catch (\Exception $e) {
            echo "\n Exception caught - ", $e->getMessage();
            return null;
        }

        return $array;
    }

    /**
     * Add news DB
     * @param  ManagerRegistry $doctrine
     * @param  array $listNews
     * @return int
     */
    public function addNewsDB(ManagerRegistry $doctrine, array $listNews): int
    {
        if (count($listNews) === 0 || !is_array($listNews["channel"])) {
            return 0;
        }
        $channel = $listNews["channel"];

        if (!is_array($channel["item"])) {
            return 0;
        }
        $items = $channel["item"];

        $entityManager = $doctrine->getManager();
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
