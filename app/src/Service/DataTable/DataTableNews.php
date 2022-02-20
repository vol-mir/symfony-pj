<?php

namespace App\Service\DataTable;

use App\Helper\DateHelper;

/**
 * Class DataTableNews
 * @package App\Service\DataTable
 */
class DataTableNews implements TableInterface
{
    /**
     * Get data
     * @param  array $listOblects
     * @param  array $columns
     * @return array
     */
    public function getData($listOblects, $columns): array
    {
        $data = [];

        foreach ($listOblects as $item) {
            $dataTemp = [];
            foreach ($columns as $column) {
                switch ($column["name"]) {
                    case "newsId":
                        $elementTemp = $item->getNewsId();
                        $dataTemp[] = $elementTemp;
                        break;

                    case "title":
                        $elementTemp = $item->getTitle();
                        $dataTemp[] = $elementTemp;
                        break;
                    case "newsDate":
                        $elementTemp = $item
                            ->getDateNews()
                            ->format(DateHelper::PHP_STANDARD_FORMAT);
                        $dataTemp[] = $elementTemp;
                        break;

                    case "fullText":
                        $elementTemp = mb_strimwidth(
                            $item->getFullText(),
                            0,
                            200,
                            "..."
                        );
                        $dataTemp[] = $elementTemp;
                        break;
                    case "category":
                        $elementTemp = $item->getCategory() ?? "-";
                        $dataTemp[] = $elementTemp;
                        break;

                    case "control":
                        $elementTemp = "";
                        $dataTemp[] = $elementTemp;
                        break;
                }
            }
            $data[] = $dataTemp;
        }

        return $data;
    }
}
