<?php

namespace App\Repository;

use App\Entity\DemandeRV;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DemandeRV|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeRV|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeRV[]    findAll()
 * @method DemandeRV[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeRVRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($registry, DemandeRV::class);
    }

    /**
     * @return DemandeRV[] Returns an array of DemandeRV objects
     */
    public function findRVByPatient(int $patient_id): array
    {
        dump($patient_id);
        $qb = $this->createQueryBuilder('d')
            ->where('d.patient = :patient_id')
            ->setParameter('patient_id', $patient_id);

        $query = $qb->getQuery();
        dump($query->execute());

        return $query->execute();
    }

    /*
    public function findOneBySomeField($value): ?DemandeRV
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
