<?php

namespace App\Service\DataTable;

/**
 * Interface TableInterface
 * @package App\Service\DataTable
 */
interface TableInterface
{
    /**
     * Get data
     * @param  array $listOblects
     * @param  array $columns
     * @return array
     */
    public function getData($listOblects, $columns): array;
}
