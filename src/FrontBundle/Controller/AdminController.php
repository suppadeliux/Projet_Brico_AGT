<?php

namespace FrontBundle\Controller;

use FrontBundle\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdminController extends Controller {

    private $confirm = false;

    public function categorieAction() {

        $formSelection = $this->getFormSelection();

        if ($formSelection->isValid()) {
            $this ->modifCategorie($formSelection);
            return $this->render('FrontBundle:Admin:confirmerModif.html.twig');
        }

        $args = array('formModif' => $formSelection->createView());

        return $this->render('FrontBundle:Admin:gestionCategorie.html.twig', $args);
    }

    protected function getFormSelection() {
        $formSelection = $this->createFormBuilder()
                ->add('categorie', ChoiceType::class, array('label' => 'Choisssez une categorie', 'choices' => array(
                        '1' => 'Electroportatif',
                        '2' => 'Equipement protection',
                        '3' => 'Levage et travail en hauteur',
                        '4' => 'Machines d\'atelier',
                        '5' => 'Matériel aménagement',
                        '6' => 'Outillage spécialisé',
                        '7' => 'Outillage à main',
                        '8' => 'Outils de jardin')))
                ->add('libelle', TextType::class, array(
                    'label' => 'Nouveau libellé :',
                    'attr' => array('class' => 'form-control',
                        'placeholder' => 'Définissez le nouveau libellé de la catégorie...')))
                ->add('submit', SubmitType::class, array('label' => 'Valider'))
                ->getForm();

        if (!$this->confirm) {
            $formSelection->handleRequest($this->get('request'));
        }

        return $formSelection;
    }

    protected function modifCategorie($formSelection) {
        $em = $this->getDoctrine()->getManager();
        
//        $selection = $this->$formSelection->get('categorie')->getData();
//        var_dump($selection);
        $newLibelle = $this->$formSelection->get('libelle')->getData();
        var_dump($newLibelle);
        
        $rep = $em->getRepository('FrontBundle:Categorie')->updateCategorie($newLibelle, $selection);
        
        $this->confirm = true;
        return $rep;
    }

}
