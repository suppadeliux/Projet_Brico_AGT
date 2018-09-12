<?php
namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class AnnonceController extends Controller
{
        
    public function viewAction($id){
	if (!(int)$id || $id <= 0)
            throw $this->createNotFoundException('Aucun article trouvé');
        // Get current post to display
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FrontBundle:Annonce');
        $posts= $repository->getById($id);
        $rep2 = $em->getRepository('FrontBundle:Categorie');
        $cats = $rep2->getCategories();
        $args = array('posts' => $posts,'cats' => $cats);
        
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
               
        return $this->render('FrontBundle:Annonce:categorie.html.twig', array(
                'cat' => $cat,
                'posts_count'=>$posts_count,
                'posts' => $posts,
                'pagination'=> $pagination,
                'cats' => $cats
                ));
    }
     
}