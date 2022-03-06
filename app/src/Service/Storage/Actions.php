<?php

namespace App\Service\Storage;

/**
 * Interface Actions
 * @package App\Service\Storage
 */
interface Actions
{
    /**
     * Save lest news and return count saved items
     * @param array $listNews
     * @return int
     */
    public function saveListNews(array $listNews): int;

}