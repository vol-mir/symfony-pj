<?php

namespace App\Service\Storage;

use App\Entity\News;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DoctrineActions
 * @package App\Service\Storage
 */
class DoctrineActions implements Actions
{
    /** @var ManagerRegistry */
    private $doctrine;

    /**
     * DoctrineActions constructor
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        /** @var TYPE_NAME $this */
        $this->doctrine = $doctrine;
    }

    /**
     * Save lest news and return count saved items
     * @param array $listNews
     * @return int
     */
    public function saveListNews(array $listNews): int
    {
        $entityManager = $this->doctrine->getManager();
        $countAddNews = 0;

        foreach ($listNews as $news) {
            if ($entityManager->getRepository(News::class)->getCountRecordsForInnerId($news->getNewsId()) > 0) {
                continue;
            }

            $entityManager->persist($news);
            $countAddNews++;
        }
        $entityManager->flush();

        return $countAddNews;
    }

}