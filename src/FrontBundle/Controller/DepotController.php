<?php
namespace FrontBundle\Controller;

use DateTime;
use DateTimeZone;
use FrontBundle\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class DepotController extends Controller
{
    private $confirm = false;
    
    public function deposerAnnonceAction(){
	$em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('FrontBundle:Categorie');
        $cats = $rep->getCategories();
        $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('search'))
                ->add('motcle', TextType::class, array('label' => false, 'attr' => array('class' => 'form-control')))
                ->add('submit', SubmitType::class, array('label' => ' ', 'attr' => array('class' => 'btn btn-default glyphicon glyphicon-search')))
                ->getForm();

        $annonce = new Annonce();
	$formAnnnonce = $this ->getFormAnnonce($annonce);

	if($formAnnnonce->isValid() && $formAnnnonce->isSubmitted()){

            // $file stores the uploaded image file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $annonce->getPhoto();
            
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            // moves the file to the directory where brochures are stored
            $file->move(
                //$this->getParameter('images_directory'),
                $this->getParameter('kernel.root_dir').'/../web/uploads/annonces',
                $fileName
            );
            // updates the 'photo' property to store the image file name
            // instead of its contents
            $annonce->setPhoto($fileName);
            
            $this ->insertAnnonce($annonce);
	    return $this->render('FrontBundle:ConfirmAnnonce:confirmer.html.twig');
	}
	    
	$args = array(	'cats' => $cats,
			'searchForm' => $form->createView(),
			'formAnnonce' => $formAnnnonce->createView(),
			'confirm' => $this -> confirm);
	
	
	return $this->render('FrontBundle:Depot:depot.html.twig', $args);
	
    }
    
    protected function getFormAnnonce($annonce) {
        $builder = $this->createFormBuilder($annonce);
	
	$titreOptions = array('label' => 'Titre de l\'annonce','constraints' => array(new NotBlank, new Length(array('min' => 5, 'max' => 100))), 
			'attr' => array('class' =>'form-control','placeholder'=>'Marteau à vendre...','aria-describedby'=>'basic-addon1'));
	$builder ->add('titre', TextType::class, $titreOptions);
	
	$typeOptions = array('label' => 'Type de l\'annonce', 'choices' => array('Pret' => '1','Location' => '2','Vente' => '3'),'choices_as_values' => true,'multiple'=>false,'expanded'=>true);
	$builder ->add('type', ChoiceType::class, $typeOptions);
	
	$builder->add('resume', TextType::class, array('label' => 'Resumé de l\'annonce', 
		    'attr' => array('class' =>'form-control','placeholder'=>'Akita', 'id'=>'comment')))
                ->add('photo', FileType::class, array('label' => 'Photo de l\'outil (jpg, png)'));
//	$builder->add('date_publication', TextType::class, array('label'=>'Date de publication'));
	$builder ->add('categorie', ChoiceType::class, array('label' => 'Choisssez une categorie', 'choices' => array(
		    '1' => 'Electroportatif',
		    '2' => 'Equipement protection',
		    '3' => 'Levage et travail en hauteur',
		    '4' => 'Machines d\'atelier',
		    '5' => 'Matériel aménagement',
		    '6' => 'Outillage spécialisé',
		    '7' => 'Outillage à main',
		    '8' => 'Outils de jardin')))
		
		->add('description', TextareaType::class, array('label' => 'description', 
		    'attr' => array('class' =>'form-control','placeholder'=>'Marteau Ã  vendre...')))
		
		->add('marque', TextType::class, array('label' => 'Marque', 
		    'attr' => array('class' =>'form-control','placeholder'=>'Akita')))
		->add('ville', TextType::class, array('label' => 'ville', 
		    'attr' => array('class' =>'form-control')))
		->add('email', EmailType::class, array('label' => 'E-mail', 
		    'attr' => array('class' =>'form-control','placeholder'=>'votremail@orange.fr')))
		->add('enregistrer', SubmitType::class, array('attr' => array('class' => 'btn btn-default')));
                
	
	$form = $builder->getForm();

        if (!$this->confirm) {
	    $form->handleRequest($this->get('request'));
        }
        
        return $form;
    }
    
    
    
    
    public function insertAnnonce($annonce) {
	
	//$annonce = new Annonce();
        $em = $this->getDoctrine()->getManager();

	$cateRepo = $em->getRepository('FrontBundle:Categorie');
        $categorie = $cateRepo->find($annonce->getCategorie());

	$now = new DateTime(null, new DateTimeZone('Europe/Paris'));
	$now->setTimestamp(time());
	
	$annonce ->setCategorie($categorie);
        $annonce ->setDatePublication($now);
        
	/*
	$annonce ->setTitre($form->get('titre')->getData());
	$annonce ->setType($form->get('type')->getData());

	$annonce ->setResume($form->get('resume')->getData());
//	$annonce ->setPhoto($form->get('photo')->getData());
	$annonce ->setDescription($form->get('description')->getData());
	$annonce ->setVille($form->get('ville')->getData());
	$annonce ->setMarque($form->get('marque')->getData());
	$annonce ->setEmail($form->get('email')->getData());
        */
	$em->persist($annonce);
	$em->flush();

	$this->confirm = true;
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}