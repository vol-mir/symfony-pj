<?php

namespace App\Service\Parser\NewsResource;

use Doctrine\Persistence\ManagerRegistry;

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

    /**
     * Add news DB
     * @param  ManagerRegistry $doctrine
     * @param  array $listNews
     * @return int
     */
    public function addNewsDB(ManagerRegistry $doctrine, array $listNews): int;

    /**
     * Get link resorce
     * @return string
     */
    public function getLinkResource(): string;
}
