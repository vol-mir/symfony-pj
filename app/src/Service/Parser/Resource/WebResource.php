<?php

namespace App\Service\Parser\Resource;

/**
 * Interface WebResource
 * @package App\Service\Parser\Resource
 */
interface WebResource
{
    /**
     * Create list news
     * @return ListNews
     */
    public function createListNews(): ListNews;
}
