<?php
namespace FrontBundle\Controller;

use FrontBundle\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdminController extends Controller {
    private $confirm = false;    
    
    public function categorieAction() {
        $formModif = $this ->getFormModification();
        if($formModif->isValid()){
            
        }
             
        return $this->render('FrontBundle:Admin:gestionCategorie.html.twig');
    }
    
    protected function getFormModification() {
        $cat = new Categorie();
        $formModif = $this->createFormBuilder($cat)
                ->add('libelle', TextType::class, array(
                    'label' => 'Libellé catégorie :',
                    'attr' => array('class' => 'form-control',
                        'placeholder' => 'Indiquez le nouveau nom de la catégorie')))                
                ->add('submit', SubmitType::class, array('label' => 'Valider'))
                ->getForm();

        if (!$this->confirm) {
            $formModif->handleRequest($this->get('request'));
        }

        return $formModif;
    }
    
    public function modifCategorie($formModif) {
        $em = $this->getDoctrine()->getManager();

        $cat = new Categorie();
        $cat->setLibelle($formModif->get('libelle')->getData());
        
        $em->persist($cat);
        $em->flush();

        $this->confirm = true;    
    }
}

