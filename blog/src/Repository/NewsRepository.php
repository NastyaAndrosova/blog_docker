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
class NewsRepository  extends ServiceEntityRepository implements NewsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function getFilteredNews(int $page, int $pageSize, ?string $date = null, ? string $tags = null): array
    {
        $queryBuilder = $this->createQueryBuilder('u');

        if($date) {
            $queryBuilder->andWhere('u.date LIKE :date')
                ->setParameter('date', $date.'-%');
        }
        if($tags) {
            $queryBuilder->andWhere('u.tags LIKE :tags')
                ->setParameter('tags', '%'.$tags.'%');
        }

        return $queryBuilder->orderBy('u.date')
            ->setMaxResults($pageSize)
            ->setFirstResult($pageSize * $page - $pageSize)
            ->getQuery()
            ->getResult();
    }
}
