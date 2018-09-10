<?php
namespace FrontBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AnnonceRepository extends EntityRepository
{
    public function getLastPosts($nbPosts)
    {
        $request = 'SELECT a FROM FrontBundle:Annonce a
            ORDER BY a.datePublication DESC, a.categorie';
        $query = $this->getEntityManager()->createQuery($request);
        $query->setFirstResult(0);
        $query->setMaxResults($nbPosts);
        return $query->getResult();
    }
    
    public function getById($idAnnonce){
        $em=$this->getEntityManager();
        $dql='SELECT a FROM FrontBundle:Annonce a WHERE a.id=:id';
        $query=$em->createQuery($dql);
        $query->setParameter('id', $idAnnonce);
        return $query->getOneOrNullResult();
    }
}