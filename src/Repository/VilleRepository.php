<?php

namespace App\Repository;

use App\Entity\Ville;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ville|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ville|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ville[]    findAll()
 * @method Ville[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VilleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ville::class);
    }

    public function getDistinctRegion()
    {
        $qb = $this->createQueryBuilder('v');

        $qb->select('DISTINCT v.code_region,v.nom_region')
            ->orderBy('v.nom_region');

        return $qb->getQuery()->getResult();
    }

    public function getRegionDepartementVille($param)
    {
        $qb = $this->createQueryBuilder('v');

        switch ($param->type){

            case 'region':
                $qb->select('DISTINCT v.code_region,v.nom_region')
                    ->orderBy('v.nom_region')
                    ->orderBy('v.nom_region');
                break;

            case 'departement':
                $qb->select('DISTINCT v.code_region,v.nom_region,v.numero_departement,v.nom_departement')
                    ->where('v.code_region = :code_region')
                    ->setParameter('code_region',$param->code_region)
                    ->orderBy('v.nom_departement');

                break;
            case 'ville':
                $qb->select('DISTINCT v.id,v.code_region,v.nom_region,
                v.numero_departement,v.nom_departement,v.code_insee,v.nom_commune')
                    ->where('v.code_region = :code_region')
                    ->andWhere('v.numero_departement = :numero_departement')
                    ->setParameter('code_region',$param->code_region)
                    ->setParameter('numero_departement',$param->numero_departement)
                    ->orderBy('v.nom_commune');

        }

        return $qb->getQuery()->getResult();
    }
    // /**
    //  * @return Contact[] Returns an array of Contact objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Contact
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
