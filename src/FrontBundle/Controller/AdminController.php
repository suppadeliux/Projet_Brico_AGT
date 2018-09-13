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
        $cat = new Categorie();
        $formModif = $this->createFormBuilder($cat)
                ->add('libelle', TextType::class, array(
                    'label' => 'Libellé catégorie :','attr' => array('class' => 'form-control',
                        'placeholder' => 'Indiquez le nouveau nom de la catégorie')))
                ->add('categorie', ChoiceType::class, array('label' => 'Choisssez une categorie', 'choices' => array(
                        '1' => 'Electroportatif',
                        '2' => 'Equipement protection',
                        '3' => 'Levage et travail en hauteur',
                        '4' => 'Machines d\'atelier',
                        '5' => 'Matériel aménagement',
                        '6' => 'Outillage spécialisé',
                        '7' => 'Outillage à main',
                        '8' => 'Outils de jardin')))
                ->add('submit', SubmitType::class, array('label' => 'Valider'))
                ->getForm();
        if (!$this->confirm) {
            $formModif->handleRequest($this->get('request'));
        }
        return $this->render('FrontBundle:Admin:gestionCategorie.html.twig');
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
