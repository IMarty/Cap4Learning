<?php

namespace App\Repository;

use App\Entity\Training;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Training|null find($id, $lockMode = null, $lockVersion = null)
 * @method Training|null findOneBy(array $criteria, array $orderBy = null)
 * @method Training[]    findAll()
 * @method Training[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Training::class);
    }

    public function findBySlug($slug, $locale): ?Training
    {
        return $this->createQueryBuilder('t')
            ->leftJoin($this->getTranslationNameDoctrine(), 'tt', 'WITH', 't.id = tt.translatable')
            ->andWhere('tt.locale = :locale')
            ->andWhere('tt.slug = :slug')
            ->andWhere('t.published = :published')
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
        return 'App:TrainingTranslation';
    }

    public function getSessionNameDoctrine()
    {
        return 'App:TrainingSession';
    }
}
