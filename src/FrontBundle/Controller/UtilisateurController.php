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

    public function loginAction() {
        return array();
    }

    public function inscriptionAction() {
        
        $em = $this->getDoctrine()->getManager();

        $rep = $em->getRepository('FrontBundle:Categorie');
        $cats = $rep->getCategories();

        $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('search'))
                ->add('motcle', TextType::class, array('label' => false, 'attr' => array('class' => 'form-control')))
                ->add('submit', SubmitType::class, array('label' => ' ', 'attr' => array('class' => 'btn btn-default glyphicon glyphicon-search')))
                ->getForm();
        
        $formInscription = $this ->getFormInscription();
        if($formInscription ->isValid()) {
            $this -> createUser($formInscription);
            $formInscription = $this ->getFormInscription();       
        }
        
        $args = array('cats' => $cats,
            'searchForm' => $form->createView(),
            'inscriptionForm' => $formInscription->createView(),
            'confirm' => $this -> confirm);

        return $this->render('FrontBundle:User:inscription.html.twig', $args);
    }

    protected function getFormInscription() {

        $user = new Utilisateur();
        $formInscription = $this->createFormBuilder($user)
                ->add('nom', TextType::class, array(
                    'label' => 'Nom :',
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
        $user -> setNom($formInscription->get('nom')->getData());
        $user -> setMdp($formInscription->get('mdp')->getData());
        $user -> setEmail($formInscription->get('email')->getData());
        $user -> setSiteWeb($formInscription->get('siteWeb')->getData());

        $em->persist($user);
        $em->flush();

        $this->confirm = true;
    }

}
