<?php
namespace FrontBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategorieRepository extends EntityRepository{
    
    public function getCategorie($idCat, $nbPosts){
        $request = 'SELECT annonces FROM FrontBundle:Categorie annonces WHERE annonces.id=:idCat';
        $query = $this -> getEntityManager() -> createQuery($request);
        $query->setParameter('idCat', $idCat);
        $query->setFirstResult(0);
        $query->setMaxResults($nbPosts);
        return $query->getOneOrNullResult();
    }
    
    public function getCategories()
    {
        $request = 'SELECT c FROM FrontBundle:Categorie c
            ORDER BY c.libelle';
        $query = $this->getEntityManager()->createQuery($request);
        return $query->getResult();
    }
    
    public function modifCategorie($newLibelle, $idCat) {
        $request = 'UPDATE c SET c.libelle=:newLibelle WHERE c.id=:idCat';
        $query = $this->getEntityManager()->createQuery($request);
        $query->setParameters(array(
            'newLibelle' => $newLibelle,
            'idCat' => $idCat
                ));
        return $query->getOneOrNullResult();
    }
}

