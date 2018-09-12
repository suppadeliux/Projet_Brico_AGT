<?php
namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RechercheController extends Controller {

    public function searchAction() {
        
        if (isset($_POST['form']['motcle']) AND !empty($_POST['form']['motcle'])) {
            $motCle = $_POST['form']['motcle'];
        }
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('search'))
            ->add('motcle', TextType::class, array('label' => false, 'attr' => array('class' => 'form-control')))
            ->add('submit', SubmitType::class, array('label' => ' ', 'attr' => array('class' => 'btn btn-default glyphicon glyphicon-search')))
            ->getForm();
        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('FrontBundle:Annonce');
        $posts = $rep->getSearchAnnonce($motCle);
        $rep2 = $em->getRepository('FrontBundle:Categorie');
        $cats = $rep2->getCategories();
        
        
        $args = array('posts' => $posts,'cats' => $cats, 'searchForm' => $form->createView());        
        var_dump($form);
        
        return $this->render('FrontBundle:Recherche:search.html.twig', $args);
    }
}
