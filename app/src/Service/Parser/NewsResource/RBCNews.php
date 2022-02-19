<?php

namespace App\Service\Parser\NewsResource;

use App\Helper\DateHelper;
use App\Helper\StringHelper;
use Symfony\Component\DomCrawler\Crawler;

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
        if (StringHelper::emptyStr($xmlPage)) {
            return null;
        }

        $xmlPage = preg_replace("/rbc_news:/", "", $xmlPage);
        $xml = simplexml_load_string($xmlPage);
        $json = json_encode($xml);
        $array = json_decode($json, true);

        return $array;
    }
}
