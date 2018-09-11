<?php
namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('FrontBundle:Annonce');
        $posts = $rep->getLastPosts(10);
                
        $rep2 = $em->getRepository('FrontBundle:Categorie');
        $cats = $rep2->getCategories();
        
        $args = array('posts' => $posts, 'cats' => $cats);
        return $this->render('FrontBundle:Default:index.html.twig', $args);
    }
    public function categorieAction()
    {
//        $em = $this->getDoctrine()->getManager();
//        $rep = $em->getRepository('FrontBundle:Categorie');
//        $cats = $rep->getCategories();
//        $args = array('cats' => $cats);
//        return $this->render('FrontBundle:Default:base.html.twig', $args);
    }
}
