<?php

namespace App\Service\Parser\Resource;

use App\Entity\News;
use App\Helper\DateHelper;
use App\Helper\StringHelper;
use Exception;

/**
 * Class RBCListNews
 * @package App\Service\Parser\Resource
 */
class RBCListNews implements ListNews
{
    private const LINK_RESOURCE = "rbc.ru";

    /**
     * Get list news from xml page
     * @param  string $xmlPage
     * @return array|null
     */
    public function getListNews(string $xmlPage): ?array
    {
        try {
            $xmlPage = preg_replace("/rbc_news:/", "", $xmlPage);
            $xml = simplexml_load_string($xmlPage);
            $json = json_encode($xml);
            $arrayNews = json_decode($json, true);
        } catch (Exception $e) {
            echo "\n Exception caught - ", $e->getMessage();
            return null;
        }

        if (count($arrayNews) === 0 || !is_array($arrayNews["channel"])) {
            return null;
        }
        $channel = $arrayNews["channel"];

        if (!is_array($channel["item"])) {
            return null;
        }
        $items = $channel["item"];

        $listNews = [];
        foreach ($items as $item) {

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

            $news->setLinkResource($this->getLinkResource());

            $listNews[] = $news;
        }
        return $listNews;
    }

    /**
     * Get link resource
     * @return string
     */
    public function getLinkResource(): string
    {
        return self::LINK_RESOURCE;
    }
}
