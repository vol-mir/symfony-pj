<?php

namespace App\Service\Storage;

use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DoctrineStorage
 * @package App\Service\Storage
 */
class DoctrineStorage implements Storage
{
    /**
     * Create DoctrineStorage
     * @return DoctrineActions
     */
    public function createStorage(ManagerRegistry $doctrine): DoctrineActions
    {
        return new DoctrineActions($doctrine);
    }
}
