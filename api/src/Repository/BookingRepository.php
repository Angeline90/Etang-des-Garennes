<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Entity\BookingState;
use App\Entity\Cottage;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 *
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function save(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Undocumented function
     *
     * @param string|DateTime $start
     * @param string|DateTime $end
     * @param Cottage|null $cottage
     * @return Booking[]
     */
    public function getListForGivenPeriod($start, $end, ?Cottage $cottage = null)
    {
        $qb = $this->createQueryBuilder('b')
            ->innerJoin(BookingState::class, 'bs', Join::WITH, 'bs.id = b.bookingState')
            ->where('
                (b.arrivalDate BETWEEN :start AND :end)
                OR (b.departureDate BETWEEN :start AND :end)
                OR (:start BETWEEN b.arrivalDate AND b.departureDate)
                OR (:end BETWEEN b.arrivalDate AND b.departureDate)
            ')
            ->andWhere('bs.state = :state')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->setParameter('state', BookingState::VALIDATE);

        if ($cottage) {
            $qb->andWhere('b.cottage = :cottage')->setParameter('cottage', $cottage);
        }



        return $qb->getQuery()->getResult();
    }


    //    /**
    //     * @return Booking[] Returns an array of Booking objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Booking
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
