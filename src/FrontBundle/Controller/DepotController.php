<?php
namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DepotController extends Controller
{
    public function deposerAnnonceAction()
    {
        
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('search'))
            ->add('motcle', TextType::class, array('label' => false, 'attr' => array('class' => 'form-control')))
            ->add('submit', SubmitType::class, array('label' => ' ', 'attr' => array('class' => 'btn btn-default glyphicon glyphicon-search')))
            ->getForm();
        $em = $this->getDoctrine()->getManager();
        $rep2 = $em->getRepository('FrontBundle:Categorie');
        $cats = $rep2->getCategories();
        
        $args = array( 'searchForm' => $form->createView(), 'cats' => $cats);
	return $this->render('FrontBundle:Depot:depot.html.twig', $args);
    }
}