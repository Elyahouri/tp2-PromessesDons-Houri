<?php

namespace App\Repository;

use App\Entity\Campaign;
use App\Entity\Donation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Campaign>
 *
 * @method Campaign|null find($id, $lockMode = null, $lockVersion = null)
 * @method Campaign|null findOneBy(array $criteria, array $orderBy = null)
 * @method Campaign[]    findAll()
 * @method Campaign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampaignRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Campaign::class);
    }

    public function save(Campaign $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Campaign $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /*public function findTop3(){
        $queryResult =  $this->getEntityManager()->createQuery(
            'SELECT campaign
            FROM App\Entity\Campaign as Campaign
            INNER JOIN App\Entity\Donation as donation with campaign.id = donation.campaign_id
            GROUP BY campaign.id 
            ORDER BY SUM(donation.amount)')
        ->setMaxResults(3);
        return $queryResult->getResult();
    }*/

    public function findTop3(){
        $queryBuilder = $this->createQueryBuilder('c')
            ->innerJoin('App\Entity\Donation', 'd','With','c.id=d.campaign_id')
            ->groupBy('c.id')
            ->orderBy('SUM(d.amount)','DESC')
            ->setMaxResults(3);
        return $queryBuilder->getQuery()->getResult();
    }

//    /**
//     * @return Campaign[] Returns an array of Campaign objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Campaign
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
