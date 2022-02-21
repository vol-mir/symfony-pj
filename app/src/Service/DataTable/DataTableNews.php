<?php

namespace App\Service\DataTable;

use App\Helper\DateHelper;
use Twig\Environment;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class DataTableNews
 * @package App\Service\DataTable
 */
class DataTableNews implements TableInterface
{
    /** @var Environment */
    private $twig;

    /** @var UrlGeneratorInterface */
    private $router;
    
    /**
     * DataTableNews constructor
     * @param  Environment $twig
     * @param  UrlGeneratorInterface $router
     * @return void
     */
    public function __construct(Environment $twig, UrlGeneratorInterface $router)
    {
        $this->twig = $twig;
        $this->router = $router;
    }

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
                $urlShow = $this->router->generate('news_show', ['news_id' => $item->getNewsId()]);

                switch ($column["name"]) {
                    case "newsId":
                        $elementTemp = $this->twig->render('default/_ahref.html.twig', [
                            'url' => $urlShow,
                            'title' => 'show news',
                            'text' => $item->getNewsId()
                        ]);
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
                        $elementTemp = "-";

                        if ($item->getCategory()) {
                            $elementTemp = $this->twig->render('default/_badge.html.twig', [
                                'type' => 'primary',
                                'value' => $item->getCategory()
                            ]);
                        }
                        $dataTemp[] = $elementTemp;
                        break;

                    case "control":
                        $elementTemp = $this->twig->render('default/_table_group_btn_sd.html.twig', [
                            'urlShow' => $urlShow,
                            'idDelete' => $item->getId()
                        ]);

                        $dataTemp[] = $elementTemp;
                        break;
                }
            }
            $data[] = $dataTemp;
        }

        return $data;
    }
}
