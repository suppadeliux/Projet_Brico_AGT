<?php

namespace FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="FrontBundle\Repository\AnnonceRepository")
 * @ORM\Table(name="annonce")
 */
class Annonce {

    /**
     * @ORM\Id
     * @ORM\Column(name="id",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=100)
     */
    private $titre;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datePublication;

    /**
     * @ORM\Column(type="string",length=20)
     */
    private $type;

    /**
     * @ORM\Column(type="text",length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string",length=300)
     */
    private $resume;

    /**
     * @ORM\Column(type="string",length=300)
     */
    private $photo; 

    /**
     * @ORM\Column(type="string",length=100)
     */
    private $marque;

    /**
     * @ORM\Column(type="string",length=100)
     */
    private $ville;

    /**
     * @ORM\Column(type="string",length=100)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="annonces")
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="annonces")
     */
    private $categorie;

    public function getId() {
        return $this->id;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function getType() {
        return $this->type;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getResume() {
        return $this->resume;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function getMarque() {
        return $this->marque;
    }

    public function getVille() {
        return $this->ville;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUtilisateur() {
        return $this->utilisateur;
    }

    public function getCategorie() {
        return $this->categorie;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
        return $this;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setResume($resume) {
        $this->resume = $resume;
        return $this;
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
        return $this;
    }

    public function setMarque($marque) {
        $this->marque = $marque;
        return $this;
    }

    public function setVille($ville) {
        $this->ville = $ville;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setUtilisateur($utilisateur) {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    public function setCategorie($categorie) {
        $this->categorie = $categorie;
        return $this;
    }

    public function getDatePublication() {
        return $this->datePublication;
    }

    public function setDatePublication($datePublication) {
        $this->datePublication = $datePublication;
        return $this;
    }

}
