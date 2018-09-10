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
     * @ORM\Column(type="string" length=100)
     */
    private $nom;
    
    /**
     * @ORM\Column(type="string" length=100)
     */
    private $mdp;
    
    /**
     * @ORM\Column(type="string" length=100)
     */
    private $email;
    
    /**
     * @ORM\Column(type="string" length=100)
     */
    private $siteWeb;
    
    /**
     * @ORM\OneToMany(targetEntity="Annonce", mappedBy="utilisateur")
     */
    private $annonces;
}
