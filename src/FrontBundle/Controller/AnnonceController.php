<?php
namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AnnonceController extends Controller
{
        
    public function viewAction($id){
	if (!(int)$id || $id <= 0){
            throw $this->createNotFoundException('Aucun article trouvé');
        }            
        // Get current post to display
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FrontBundle:Annonce');
        $posts= $repository->getById($id);
        $rep2 = $em->getRepository('FrontBundle:Categorie');
        $cats = $rep2->getCategories();
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('search'))
            ->add('motcle', TextType::class, array('label' => false, 'attr' => array('class' => 'form-control')))
            ->add('submit', SubmitType::class, array('label' => ' ', 'attr' => array('class' => 'btn btn-default glyphicon glyphicon-search')))
            ->getForm();
        
        $args = array('posts' => $posts,'cats' => $cats, 'searchForm' => $form->createView());
        
        return $this->render('FrontBundle:Annonce:annonce.html.twig', $args);	
    }
    
    public function categorieAction($id, $page) {
        if(!(int)$id || $id <=0){
            throw $this->createNotFoundException('Aucune catégorie trouvée');
        }
        $maxPosts = 20;
        $em = $this->getDoctrine()->getManager();
        
        $cat = $em->getRepository('FrontBundle:Categorie')->findOneBy(array('id' => $id));
        
        $posts_count = $this->getDoctrine()->getRepository('FrontBundle:Annonce')->getCountByCat($id);        
        $val = (int)$posts_count[1];
        
        $posts = $this->getDoctrine()->getRepository('FrontBundle:Annonce')-> getByCat($id, $maxPosts, $page);
              
        $pages_count = \ceil( $val / $maxPosts);
        
        $pagination = array(
                'page' => $page,
                'route' => 'categorie',
                'pages_count' => $pages_count,
                'route_params' => array()
            );
        
        $rep2 = $em->getRepository('FrontBundle:Categorie');
        $cats = $rep2->getCategories();
        
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('search'))
            ->add('motcle', TextType::class, array('label' => false, 'attr' => array('class' => 'form-control')))
            ->add('submit', SubmitType::class, array('label' => ' ', 'attr' => array('class' => 'btn btn-default glyphicon glyphicon-search')))
            ->getForm();
               
        return $this->render('FrontBundle:Annonce:categorie.html.twig', array(
                'cat' => $cat,
                'posts_count'=>$posts_count,
                'posts' => $posts,
                'pagination'=> $pagination,
                'cats' => $cats,
                'searchForm' => $form->createView()
                ));
    }
     
}