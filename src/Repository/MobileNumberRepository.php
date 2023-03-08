<?php

namespace App\Repository;

use App\Entity\MobileNumber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MobileNumber>
 *
 * @method MobileNumber|null find($id, $lockMode = null, $lockVersion = null)
 * @method MobileNumber|null findOneBy(array $criteria, array $orderBy = null)
 * @method MobileNumber[]    findAll()
 * @method MobileNumber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MobileNumberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MobileNumber::class);
    }

    public function sumaBalances(): array
    {
        return $this->createQueryBuilder('mn')
            ->join('mn.user', 'u')
            ->select('u.firstName, u.lastName, mn.nameOperator, SUM(mn.balance) as sumaBalances')
            ->groupBy('u.firstName, u.lastName, mn.nameOperator')
            ->getQuery()
            ->getResult()
            ;
    }

    //Count numbers by every code operator
    public function countNumbers(): array
    {
        return $this->createQueryBuilder('mn')
            ->join('mn.user', 'u')
            ->select('mn.codeOperator, COUNT(mn.number) as countNumbers')
            ->groupBy('mn.codeOperator')
            ->getQuery()
            ->getResult()
            ;
    }

    //Users and count of phone numbers.
    public function countNumbersEveryUser(): array
    {
        return $this->createQueryBuilder('mn')
            ->join('mn.user', 'u')
            ->select('u.firstName, u.lastName, COUNT(mn.number) as phoneNumbers')
            ->groupBy('u.firstName, u.lastName')
            ->getQuery()
            ->getResult()
            ;
    }

    //The ten users with max balance
    public function getUsersWithBalance(): array
    {
        return $this->createQueryBuilder('mn')
            ->join('mn.user', 'u')
            ->select('u.firstName, u.lastName, mn.balance')
            ->groupBy('u.firstName, u.lastName, mn.balance')
            ->orderBy('mn.balance','DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    public function save(MobileNumber $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MobileNumber $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MobileNumber[] Returns an array of MobilePhone objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MobileNumber
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
