<?php
namespace FrontBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UtilisateurRepository extends EntityRepository {

    public function checkLogin($nom, $mdp) {
        $request = 'SELECT u FROM FrontBundle:Utilisateur u WHERE u.nom=:nom AND u.mdp=:mdp';
        $query = $this->getEntityManager()->createQuery($request);
        $query->setParameters(array(
            'nom' => $nom,
            'mdp' => $mdp
                ));
        return $query->getOneOrNullResult();
    }

}
