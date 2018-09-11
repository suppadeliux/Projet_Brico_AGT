<?php

namespace FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity (repositoryClass="FrontBundle\Repository\AnnonceRepository")
 * @ORM\Table(name="categorie")
 */
class Categorie {

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
     * @ORM\OneToMany(targetEntity="FrontBundle\Entity\Annonce",mappedBy="categorie")
     */
    private $annonces;

    public function getId() {
        return $this->id;
    }

    public function getLibelle() {
        return $this->libelle;
    }

    public function getAnnonces() {
        return $this->annonces;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
        return $this;
    }

    public function setAnnonces($annonces) {
        $this->annonces = $annonces;
        return $this;
    }

}
