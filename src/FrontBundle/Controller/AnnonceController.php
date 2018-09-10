<?php
namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}