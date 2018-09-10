<?php
namespace FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="utilisateur")
 */
class Utilisateur {
    
     /**
     * @ORM\Id
     * @ORM\Column(name="id",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string",length=100)
     */
    private $nom;
    
    /**
     * @ORM\Column(type="string",length=100)
     */
    private $mdp;
    
    /**
     * @ORM\Column(type="string",length=100)
     */
    private $email;
    
    /**
     * @ORM\Column(type="string",length=100,nullable=true)
     */
    private $siteWeb;
    
    /**
     * @ORM\OneToMany(targetEntity="Annonce", mappedBy="utilisateur")
     */
    private $annonces;
    
    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getMdp() {
        return $this->mdp;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSiteWeb() {
        return $this->siteWeb;
    }

    public function getAnnonces() {
        return $this->annonces;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    public function setMdp($mdp) {
        $this->mdp = $mdp;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setSiteWeb($siteWeb) {
        $this->siteWeb = $siteWeb;
        return $this;
    }

    public function setAnnonces($annonces) {
        $this->annonces = $annonces;
        return $this;
    }
}    