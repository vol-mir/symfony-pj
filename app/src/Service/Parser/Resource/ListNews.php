<?php

namespace App\Service\Parser\Resource;

use Doctrine\Persistence\ManagerRegistry;

/**
 * Interface ListNews
 * @package App\Service\Parser\Resource
 */
interface ListNews
{
    /**
     * Get list news from xml page
     * @param  string $xmlPage
     * @return array|null
     */
    public function getListNews(string $xmlPage): ?array;

    /**
     * Get link resource
     * @return string
     */
    public function getLinkResource(): string;
}
