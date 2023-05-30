<?php

namespace App\Repository;

use App\Entity\AccountBalance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AccountBalance>
 *
 * @method AccountBalance|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccountBalance|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccountBalance[]    findAll()
 * @method AccountBalance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountBalanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountBalance::class);
    }

    public function save(AccountBalance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AccountBalance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return AccountBalance[] Returns an array of AccountBalance objects
     */
    public function findAccountByCode($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.code = :val')
            ->setParameter('val', $value)
            ->orderBy('a.name', 'DESC');
        // ->setMaxResults(10)
        // ->getQuery()
        // ->getResult();
    }

    //    public function findOneBySomeField($value): ?AccountBalance
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
