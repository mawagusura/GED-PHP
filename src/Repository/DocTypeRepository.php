<?php
/**
 * Created by PhpStorm.
 * User: Lucas EFREI
 * Date: 15/07/2018
 * Time: 14:33
 */

namespace App\Repository;
use App\Entity\DocType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
/**
 * @method DocType|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocType|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocType[]    findAll()
 * @method DocType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DocType::class);
    }

}