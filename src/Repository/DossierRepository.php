<?php
/**
 * Created by PhpStorm.
 * User: Amaury
 * Date: 14/07/2018
 * Time: 11:23
 */

namespace App\Repository;

use App\Entity\Dossier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Dossier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dossier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dossier[]    findAll()
 * @method Dossier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DossierRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Dossier::class);
    }
}