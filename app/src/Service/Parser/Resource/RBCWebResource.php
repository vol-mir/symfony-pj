<?php

namespace App\Service\Parser\Resource;

/**
 * Class RBCWebResource
 * @package App\Service\Parser\Resource
 */
class RBCWebResource implements WebResource
{
    /**
     * Create news list
     * @return ListNews
     */
    public function createListNews(): ListNews
    {
        return new RBCListNews();
    }
}
