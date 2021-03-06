<?php

namespace App\Repository;

use App\Entity\Visiteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Visiteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visiteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visiteur[]    findAll()
 * @method Visiteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisiteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visiteur::class);
    }

    // /**
    //  * @return Visiteur[] Returns an array of Visiteur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Visiteur
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findAllVisiteur(){ 
        // Création du QueryBuilder

        $queryBuilder = $this->_em->createQueryBuilder()
                ->select('v')
                ->from(Visiteur::class,'v') ;

        // récupérer la requête
        $query = $queryBuilder->getQuery();
        // Les résultats
        $resultats = $query->getResult();

    }
    
    
    public function deleteVisiteur($id) {
        $queryBuilder = $this->_em->createQueryBuilder()
            ->delete('v')
            ->from(Visiteur::class,'v')
            ->where('v.id = :id')
            ->setParameter('id',$id);
        
        $result =  $queryBuilder->getQuery()->getResult();

        return $result;
    
    }
    
    
}
