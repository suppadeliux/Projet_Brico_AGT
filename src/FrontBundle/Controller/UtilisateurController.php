<?php

namespace FrontBundle\Controller;

use FrontBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class UtilisateurController extends Controller {

    private $confirm = false;
    private $submit = false;

    public function inscriptionAction() {

        $em = $this->getDoctrine()->getManager();

        $rep = $em->getRepository('FrontBundle:Categorie');
        $cats = $rep->getCategories();

        $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('search'))
                ->add('motcle', TextType::class, array('label' => false, 'attr' => array('class' => 'form-control')))
                ->add('submit', SubmitType::class, array('label' => ' ', 'attr' => array('class' => 'btn btn-default glyphicon glyphicon-search')))
                ->getForm();

        $formInscription = $this->getFormInscription();
        if ($formInscription->isValid()) {
            $this->createUser($formInscription);
            $formInscription = $this->getFormInscription();
        }

        $args = array('cats' => $cats,
            'searchForm' => $form->createView(),
            'inscriptionForm' => $formInscription->createView(),
            'confirm' => $this->confirm);

        return $this->render('FrontBundle:User:inscription.html.twig', $args);
    }

    protected function getFormInscription() {
        $user = new Utilisateur();
        $formInscription = $this->createFormBuilder($user)
                ->add('nom', TextType::class, array(
                    'label' => 'Identifiant :',
                    'attr' => array('class' => 'form-control',
                        'placeholder' => 'Votre nom...')))
                ->add('mdp', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options' => array('label' => 'Mot de passe :',
                        'attr' => array('class' => 'form-control',
                            'placeholder' => 'Votre mot de passe...')),
                    'second_options' => array('label' => 'Confirmer mot de passe :',
                        'attr' => array('class' => 'form-control',
                            'placeholder' => 'Confirmer votre mot de passe...'))))
                ->add('email', EmailType::class, array(
                    'label' => 'Email :',
                    'attr' => array('class' => 'form-control',
                        'placeholder' => 'Votre Email...')))
                ->add('siteWeb', UrlType::class, array(
                    'label' => 'Site Web (facultatif) :',
                    'required' => false,
                    'attr' => array('class' => 'form-control',
                        'placeholder' => 'Votre site web...')))
                ->add('submit', SubmitType::class, array('label' => 'Valider'))
                ->getForm();

        if (!$this->confirm) {
            $formInscription->handleRequest($this->get('request'));
        }

        return $formInscription;
    }

    public function createUser($formInscription) {
        $em = $this->getDoctrine()->getManager();

        $user = new Utilisateur();
        $user->setNom($formInscription->get('nom')->getData());
        $user->setMdp($formInscription->get('mdp')->getData());
        $user->setEmail($formInscription->get('email')->getData());
        $user->setSiteWeb($formInscription->get('siteWeb')->getData());

        $em->persist($user);
        $em->flush();

        $this->confirm = true;
    }

    public function connexionAction() {
        $em = $this->getDoctrine()->getManager();

        $rep = $em->getRepository('FrontBundle:Categorie');
        $cats = $rep->getCategories();

        $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('search'))
                ->add('motcle', TextType::class, array('label' => false, 'attr' => array('class' => 'form-control')))
                ->add('submit', SubmitType::class, array('label' => ' ', 'attr' => array('class' => 'btn btn-default glyphicon glyphicon-search')))
                ->getForm();

        $rep2 = $em->getRepository('FrontBundle:Annonce');
        $posts = $rep2->getLastPosts(10);

        $formConnexion = $this->getFormConnexion();

        if ($formConnexion->isValid() && $formConnexion->isSubmitted()) {
            $verif = $this->checkConnexion($formConnexion);
            if ($this->confirm === true && $this->submit === true) {
                $typeUser = $verif->getType()->getId();
                $args = array('cats' => $cats,
                    'searchForm' => $form->createView(),
                    'connexionForm' => $formConnexion->createView(),
                    'submit' => $this->submit,
                    'confirm' => $this->confirm,
                    'typeUser' => $typeUser,
                    'posts' => $posts);
                if ($typeUser === 1) {
                    return $this->render('FrontBundle:Admin:admin.html.twig', $args);
                } else {
                    return $this->render('FrontBundle:Default:index.html.twig', $args);
                }
            }
        }
       
        $args = array('cats' => $cats,
            'searchForm' => $form->createView(),
            'connexionForm' => $formConnexion->createView(),
            'submit' => $this->submit,
            'confirm' => $this->confirm);


        return $this->render('FrontBundle:User:connexion.html.twig', $args);
    }

    public function getFormConnexion() {
        $user = new Utilisateur();
        $formConnexion = $this->createFormBuilder($user)
                ->add('nom', TextType::class, array(
                    'label' => 'Identifiant :',
                    'attr' => array('class' => 'form-control',
                        'placeholder' => 'Votre identifiant de connexion...')))
                ->add('mdp', PasswordType::class, array(
                    'label' => 'Mot de passe :',
                    'attr' => array('class' => 'form-control',
                        'placeholder' => 'Votre mot de passe...')))
                ->add('submit', SubmitType::class, array('label' => 'Connexion'))
                ->getForm();

        if (!$this->confirm) {
            $formConnexion->handleRequest($this->get('request'));
        }

        return $formConnexion;
    }

    public function checkConnexion($formConnexion) {
        $em = $this->getDoctrine()->getManager();

        $nom = $formConnexion->get('nom')->getData();
        $mdp = $formConnexion->get('mdp')->getData();

        $repository = $em->getRepository('FrontBundle:Utilisateur');
        $verif = $repository->checkLogin($nom, $mdp);

        if ($verif === null) {
            $this->submit = true;
            return $this->confirm;
        } else {
            $this->submit = true;
            $this->confirm = true;
            return $verif;
        }
    }

}
