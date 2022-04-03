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
     * Get news 
     */    
    public function getLastNews($limit)
    {
        return $this
            ->createQueryBuilder('n')
            ->orderBy("n.date_news", 'DESC')
            ->setFirstResult(0)
            ->setMaxResults($limit)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * Count news for inner news ID
     * @param  int $newsId
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
    
}
