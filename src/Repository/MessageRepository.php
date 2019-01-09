<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
* @method Message|null find($id, $lockMode = null, $lockVersion = null)
* @method Message|null findOneBy(array $criteria, array $orderBy = null)
* @method Message[]    findAll()
* @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
*/
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Message::class);
    }
    
    public function messagesA($idUser, $idUtilisateur, $idLastMess)
    {
        return $this->createQueryBuilder('m')
        ->join('m.User', 'u')
        ->addSelect('u.id')
        ->Where('m.User = :idUser AND m.messagesRecus = :idUtilisateur AND m.id > :idlastmess')
        ->orWhere('m.User = :idUtilisateur AND m.messagesRecus = :idUser AND m.id > :idlastmess')
        ->setParameter('idUser', $idUser)
        ->setParameter('idUtilisateur', $idUtilisateur)
        ->setParameter('idlastmess', $idLastMess)
        ->OrderBy('m.id')
        ->getQuery()
        ->getArrayResult();
    }

    public function messages($idUser, $idUtilisateur)
    {
        return $this->createQueryBuilder('m')
        ->Where('m.User = :idUser AND m.messagesRecus = :idUtilisateur')
        ->orWhere('m.User = :idUtilisateur AND m.messagesRecus = :idUser')
        ->setParameter('idUser', $idUser)
        ->setParameter('idUtilisateur', $idUtilisateur)
        ->getQuery()
        ->execute();
    }
    
    // /**
    //  * @return Message[] Returns an array of Message objects
    //  */
    /*
    
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
        ->andWhere('m.exampleField = :val')
        ->setParameter('val', $value)
        ->orderBy('m.id', 'ASC')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult()
        ;
    }
    */
    
    /*
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
        ->andWhere('m.exampleField = :val')
        ->setParameter('val', $value)
        ->getQuery()
        ->getOneOrNullResult()
        ;
    }
    */
}
