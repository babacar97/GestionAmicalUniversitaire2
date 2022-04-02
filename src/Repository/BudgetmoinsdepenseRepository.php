<?php

namespace App\Repository;

use App\Entity\Budgetmoinsdepense;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Budgetmoinsdepense|null find($id, $lockMode = null, $lockVersion = null)
 * @method Budgetmoinsdepense|null findOneBy(array $criteria, array $orderBy = null)
 * @method Budgetmoinsdepense[]    findAll()
 * @method Budgetmoinsdepense[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BudgetmoinsdepenseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Budgetmoinsdepense::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Budgetmoinsdepense $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Budgetmoinsdepense $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Budgetmoinsdepense[] Returns an array of Budgetmoinsdepense objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Budgetmoinsdepense
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
