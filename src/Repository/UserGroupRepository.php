<?php

namespace App\Repository;

use App\Entity\UserGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserGroup[]    findAll()
 * @method UserGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserGroupRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserGroup::class);
    }

    public function findCount($groupId)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT COUNT(a.group_id) FROM user_group a WHERE a.group_id = :group_id
        ';
        $stmt = $conn->prepare($sql);
         $stmt->execute(['group_id' => $groupId]);
         $count = $stmt->fetchColumn(0);
         return $count;

        // return $this->getEntityManager()
        //     ->createQuery('SELECT COUNT(a) FROM App\Entity\UserGroup a WHERE a.group_id = :group_id')
        //     ->setParameter('group_id', $groupId)
        //     ->getSingleScalarResult();
    }

    // /**
    //  * @return UserGroup[] Returns an array of UserGroup objects
    //  */
    /*
    public function findByExampleField($value)
    {
    return $this->createQueryBuilder('u')
    ->andWhere('u.exampleField = :val')
    ->setParameter('val', $value)
    ->orderBy('u.id', 'ASC')
    ->setMaxResults(10)
    ->getQuery()
    ->getResult()
    ;
    }
     */

    /*
public function findOneBySomeField($value): ?UserGroup
{
return $this->createQueryBuilder('u')
->andWhere('u.exampleField = :val')
->setParameter('val', $value)
->getQuery()
->getOneOrNullResult()
;
}
 */
}
