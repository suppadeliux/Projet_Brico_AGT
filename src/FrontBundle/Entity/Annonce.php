<?php
namespace FrontBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
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
    * @ORM\Column(type="string",length=150)
    */
    private $type;
    
    /**
    * @ORM\Column(type="string",length=255)
    */
    private $description;
    
    /**
    * @ORM\Column(type="string",length=255)
    */
    private $resume;
    
    /**
    * @ORM\Column(type="blob",length=255)
    */
    private $photo;
    private $marque;
    private $ville;
    private $email;
    private $utilisateur;
    private $categorie;
    
    
}
