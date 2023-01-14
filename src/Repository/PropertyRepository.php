<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Property>
 *
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    public function save(Property $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Property $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllVisibleQuery(PropertySearch $search): Query
    {
        $query = $this->queryBase();

        if ($search->getMaxPrice()) {
            $query = $query->andWhere('p.price <= :maxprice')
                ->setParameter('maxprice', $search->getMaxPrice());
        }

        if ($search->getMinSurface()) {
            $query = $query->andWhere('p.surface >= :minsurface')
            ->setParameter('minsurface', $search->getMinSurface());
        }

        if ($search->getOptions()->count() > 0) {
            foreach ($search->getOptions() as $key => $option) {
                $query = $query->andWhere(":option$key MEMBER OF p.options")
                ->setParameter("option$key", $option);
            }
        }

        if ($search->getLat() && $search->getLng() && $search->getDistance()) {
            $query = $query
            ->andWhere('(6353 * 2 * ASIN(SQRT( POWER(SIN((p.lat - :lat) *  pi()/180 / 2), 2) +COS(p.lat * pi()/180) 
             * COS(:lat * pi()/180) * POWER(SIN((p.lng - :lng) * pi()/180 / 2), 2) ))) <= :distance')
            ->setParameter('lng', $search->getLng())
            ->setParameter('lat', $search->getLat())
            ->setParameter('distance', $search->getDistance());
            ;
        }

        return $query->getQuery();
    }

    public function findLatest(): array
    {
        return $this->queryBase()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    private function queryBase(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false');
    }
//    /**
//     * @return Property[] Returns an array of Property objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Property
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
