<?php

// src/Demo/CoreBundle/Controller/DefaultController.php

namespace Demo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

//  Appel de PlatformBundle pour utiliser le bundle d'annonces
use Symfony\Component\HttpFoundation\Request;
use PlatformBundle\Controller\AdvertController;
use ForumBundle\Controller\ForumController;


class CoreController extends Controller
{
    
    // Get the last x adverts and display in the index View 
    // Routing : DemoCoreBundle:Core:index
    // Routing Param : 
    public function indexAction(){
        $listAdverts = $this->container->get('demo_core.platform')->getLastAdvertsAction(3);
        return $this->render('DemoCoreBundle:Core:index.html.twig',array('listAdverts' => $listAdverts));
    }
    
    // Display the contact page
    // Routing : DemoCoreBundle:Core:contact
    public function contactAction(Request $request){
        $session = $request->getSession();
        $session->getFlashBag()->add('info', 'La page de contact n\'existe pas encore, ça arrivera bientôt ;)');
        return $this->render('DemoCoreBundle:Core:contact.html.twig');
    }
}
