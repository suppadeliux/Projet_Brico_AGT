<?php
namespace FrontBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AnnonceRepository extends EntityRepository
{
    public function getLastPosts($nbPosts)
    {
        $request = 'SELECT a FROM FrontBundle:Annonce a
            ORDER BY a.datePublication DESC, a.categorie';
        $query = $this -> getEntityManager() -> createQuery($request);
        $query->setFirstResult(0);
        $query->setMaxResults($nbPosts);
        return $query->getResult();
    }
    
    public function getCategories()
    {
        $request = 'SELECT c FROM FrontBundle:Categorie c
            ORDER BY c.libelle';
        $query = $this->getEntityManager()->createQuery($request);
        return $query->getResult();
    }
    
    public function getById($idAnnonce){
        $request = 'SELECT a FROM FrontBundle:Annonce a WHERE a.id=:id';
        $query= $this -> getEntityManager() -> createQuery($request);
        $query->setParameter('id', $idAnnonce);
        return $query->getOneOrNullResult();
    }
    
    public function getByCat($idCat, $nbPosts, $page) {
        $request = 'SELECT a FROM FrontBundle:Annonce a WHERE a.categorie=:idCat';
        $query = $this -> getEntityManager() -> createQuery($request);
        $query -> setParameter('idCat', $idCat);
        $query -> setFirstResult(($page-1) * $nbPosts);
        $query -> setMaxResults($nbPosts);
        return new Paginator($query);
    }
    
    public function getCountByCat($idCat){
        $request = 'SELECT COUNT(a) FROM FrontBundle:Annonce a WHERE a.categorie=:idCat';
        $query = $this -> getEntityManager() -> createQuery($request);
        $query -> setParameter('idCat', $idCat);
        return $query->getOneOrNullResult();
    }
    
    public function getSearchAnnonce($motcle) {
        $req = "SELECT a, c FROM FrontBundle:Annonce a JOIN a.categorie c WHERE a.ville LIKE '%$motcle%' OR a.description LIKE '%$motcle%' OR a.resume LIKE '%$motcle%' OR c.libelle LIKE '%$motcle%' ORDER BY a.id DESC, c.id DESC";

        $query = $this->getEntityManager()->createQuery($req);
        return $query->getResult();
    }
}
