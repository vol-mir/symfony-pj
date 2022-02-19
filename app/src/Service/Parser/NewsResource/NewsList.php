<?php

namespace App\Service\Parser\NewsResource;

/**
 * Interface NewsList
 * @package App\Service\Parser\NewsResource
 */
interface NewsList
{
    /**
     * Get list news
     * @param  string $xmlPage
     * @return array|null
     */
    public function getListNews(string $xmlPage);
}
