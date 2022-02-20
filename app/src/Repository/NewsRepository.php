<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    /**
     * NewsRepository constructor
     * @param  mixed $registry
     * @return void
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }
    
    /**
     * Get count records
     * @return void
     */
    public function getCountRecords()
    {
        return $this
            ->createQueryBuilder('n')
            ->select("count(n.id)")
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Count news for inner news ID
     * @param  mixed $newsId
     * @return void
     */    
    public function getCountRecordsForInnerId($newsId)
    {
        return $this
            ->createQueryBuilder('n')
            ->select("count(n.id)")
            ->where('n.news_id = :newsId')
            ->setParameter('newsId', $newsId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Get list for DT
     * @param  int $start
     * @param  int $length
     * @param  array $orders
     * @param  array $search
     * @return array
     */
    public function getListForDT($start, $length, $orders, $search): array
    {
        // Create Main Query
        $query = $this->createQueryBuilder("n");

        // Create Count Query
        $countQuery = $this->createQueryBuilder("n");
        $countQuery->select("COUNT(n)");

        // Fields Search
        if ($search["value"] !== "") {
            $searchItem = $search["value"];
            $searchQuery = 'n.news_id LIKE \'%' . $searchItem . '%\'';
            $searchQuery .= ' or n.title LIKE \'%' . $searchItem . '%\'';
            $searchQuery .= ' or n.date_news LIKE \'%' . $searchItem . '%\'';
            $searchQuery .= ' or n.full_text LIKE \'%' . $searchItem . '%\'';
            $searchQuery .= ' or n.category LIKE \'%' . $searchItem . '%\'';

            $query->andWhere($searchQuery);
            $countQuery->andWhere($searchQuery);
        }

        // Limit
        $query->setFirstResult($start)->setMaxResults($length);

        // Order
        foreach ($orders as $key => $order) {
            if ($order["name"] !== "") {
                switch ($order["name"]) {
                    case "newsId":
                        $query->orderBy("n.news_id", $order["dir"]);
                        break;
                    case "title":
                        $query->orderBy("n.title", $order["dir"]);
                        break;
                    case "newsDate":
                        $query->orderBy("n.date_news", $order["dir"]);
                        break;
                    case "fullText":
                        $query->orderBy("n.full_text", $order["dir"]);
                        break;
                    case "category":
                        $query->orderBy("n.category", $order["dir"]);
                        break;
                }
            }
        }

        // Execute
        $listOblects = $query->getQuery()->getResult();
        $listCount = $countQuery->getQuery()->getSingleScalarResult();

        return [
            'listOblects' => $listOblects, 
            'listCount' => $listCount,
            'countRecords' => $this->getCountRecords()
        ];
    }
}
