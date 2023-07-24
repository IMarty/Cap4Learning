<?php

namespace App\Repository;

use App\Entity\TrainingCategory;
use App\Entity\TrainingCategoryTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TrainingCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingCategory[]    findAll()
 * @method TrainingCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingCategory::class);
    }

    public function findBySlug($slug, $locale): ?TrainingCategory
    {
        return $this->createQueryBuilder('tc')
            ->leftJoin('App:TrainingCategoryTranslation', 'tct', 'WITH', 'tc.id = tct.translatable')
            ->andWhere('tct.locale = :locale')
            ->andWhere('tct.slug = :slug')
            ->setParameter('slug', $slug)
            ->setParameter('locale', $locale)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function findByTranslationOrder($field, $ordering, $locale): ?array
    {
        return $this->createQueryBuilder('tc')
            ->leftJoin('App:TrainingCategoryTranslation', 'tct', 'WITH', 'tc.id = tct.translatable')
            ->andWhere('tct.locale = :locale')
            ->setParameter('locale', $locale)
            ->orderBy('tct.'.$field, $ordering)
            ->getQuery()
            ->getResult()
        ;
    }
}
