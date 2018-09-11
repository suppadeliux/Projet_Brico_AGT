<?php
namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class AnnonceController extends Controller
{
    
    public function annonceAction($id)
    {
        if(!(int)$id || $id <=0){
            throw $this->createNotFoundException('Aucun article trouvé');
        }
        $em=$this->getDoctrine()->getManager();
        $repository=$em->getRepository("FrontBundle:Annonce");
        $posts= $repository->getById($id); 
        return array('post'=>$posts);
    }
    public function viewAction($id){
	if (!(int)$id)
            throw $this->createNotFoundException('Aucun article trouvé');

        // Get current post to display
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FrontBundle:Annonce');
        $posts= $repository->getById($id);
        $rep2 = $em->getRepository('FrontBundle:Categorie');
        $cats = $rep2->getCategories();
        $args = array('post' => $posts,'cats' => $cats);
        return $this->render('FrontBundle:Annonce:annonce.html.twig', $args);
	
    }
}