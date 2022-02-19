<?php

namespace App\Service\Parser\NewsResource;

/**
 * Interface NewsFactory
 * @package App\Service\Parser\NewsResource
 */
interface NewsFactory
{
    /**
     * Create list news 
     * @return NewsList
     */
    public function createListNews(): NewsList;
}
