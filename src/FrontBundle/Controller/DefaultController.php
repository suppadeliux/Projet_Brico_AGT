<?php
namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    
class DefaultController extends Controller { 
    
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('FrontBundle:Annonce');
        $posts = $rep->getLastPosts(10);       
        $rep2 = $em->getRepository('FrontBundle:Categorie');
        $cats = $rep2->getCategories();
        
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('search'))
            ->add('motcle', TextType::class, array('label' => false, 'attr' => array('class' => 'form-control')))
            ->add('submit', SubmitType::class, array('label' => ' ', 'attr' => array('class' => 'btn btn-default glyphicon glyphicon-search')))
            ->getForm();
        
        $args = array('posts' => $posts,'cats' => $cats, 'searchForm' => $form->createView());
        return $this->render('FrontBundle:Default:index.html.twig', $args);
    }
        
}
