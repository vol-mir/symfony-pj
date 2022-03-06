<?php

namespace App\Service\Storage;

use Doctrine\Persistence\ManagerRegistry;

/**
 * Interface Storage
 * @package App\Service\Storage
 */
interface Storage
{
    /**
     * Create DoctrineStorage
     * @param ManagerRegistry $doctrine
     * @return DoctrineActions
     */
    public function createStorage(ManagerRegistry $doctrine): DoctrineActions;
}
