<?php
namespace FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="TypeUtilisateur")
 */
class TypeUtilisateur {
    /**
     * @ORM\Id
     * @ORM\Column(name="id",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string",length=50)
     */
    private $libelle;
    
    /**
     * @ORM\OneToMany(targetEntity="FrontBundle\Entity\Utilisateur",mappedBy="type")
     */
    private $users;
    
    public function getId() {
        return $this->id;
    }

    public function getLibelle() {
        return $this->libelle;
    }

    public function getUsers() {
        return $this->users;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
        return $this;
    }

    public function setUsers($users) {
        $this->users = $users;
        return $this;
    }

}
