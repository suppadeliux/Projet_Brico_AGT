<?php
namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RechercheController extends Controller {

    public function searchAction() {
        
        if (isset($_POST['form']['motcle']) AND ! empty($_POST['form']['motcle'])) {
            $motCle = $_POST['form']['motcle'];
        }
        
        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('FrontBundle:Annonce');
        $posts = $rep->getSearchAnnonce($motCle);
        $rep2 = $em->getRepository('FrontBundle:Categorie');
        $cats = $rep2->getCategories();
        
        
        $args = array('posts' => $posts,'cats' => $cats);
        return $this->render('FrontBundle:Recherche:index.html.twig', $args);
    }
}
