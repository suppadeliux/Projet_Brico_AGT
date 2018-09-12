<?php
namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DepotController extends Controller
{
    public function deposerAnnonceAction()
    {
	return $this->render('FrontBundle:Depot:depot.html.twig');
    }
}

