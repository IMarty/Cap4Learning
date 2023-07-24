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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function findBySlug($slug, $locale): ?News
    {
        return $this->createQueryBuilder('n')
            ->leftJoin('App:NewsTranslation', 'nt', 'WITH', 'n.id = nt.translatable')
            ->andWhere('nt.locale = :locale')
            ->andWhere('nt.slug = :slug')
            ->andWhere('n.published = :published')
            ->setParameter('slug', $slug)
            ->setParameter('locale', $locale)
            ->setParameter('published', true)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function getTranslationNameDoctrine()
    {
        return 'App:NewsTranslation';
    }
}
