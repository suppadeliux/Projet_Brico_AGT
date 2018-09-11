<?php
namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CategorieController extends Controller {

    public function categorieAction($id) {
        if(!(int)$id || $id <=0){
            throw $this->createNotFoundException('Aucune catégorie trouvée');
        }
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FrontBundle:Categorie');
        $cat = $repository -> getCategorie($id, 20);      
        return $this->render('FrontBundle:Annonce:categorie.html.twig', array('cat'=>$cat));
    }
    
    
}
