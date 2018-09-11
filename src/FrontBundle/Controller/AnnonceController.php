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
        $args = array('post' => $posts);
        
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
        
        $posts = $this->getDoctrine()->getRepository('FrontBundle:Annonce')-> getByCat($id, $maxPosts, $page);
        
        $pages_count = \ceil(26 / $maxPosts);
        
        $pagination = array(
                'page' => $page,
                'route' => 'categorie',
                'pages_count' => $pages_count,
                'route_params' => array()
            );
               
        return $this->render('FrontBundle:Annonce:categorie.html.twig', array(
                'cat' => $cat,
                'posts_count'=>$posts_count,
                'posts' => $posts,
                'pagination'=> $pagination,
                ));
    }
     
}