<?php

namespace App\Service\Parser\NewsResource;

/**
 * Class RBCNewsFactory
 * @package App\Service\Parser\NewsResource
 */
class RBCNewsFactory implements NewsFactory
{
    /**
     * Create news list
     * @return NewsList
     */
    public function createListNews(): NewsList
    {
        return new RBCNews();
    }
}
