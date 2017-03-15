<?php

// src/Demo/PlatformBundle/Controller/AdvertController.php

namespace Demo\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Il faut étendre le contrôleur pour accéder aux fonctions
class AdvertController extends Controller
{
    public function indexAction()
    {
        // Index v1
        $content = $this->get('templating')->render('DemoPlatformBundle:Advert:index.html.twig', array('nom' => 'Erwan'));
        return new Response($content);
        
        // Index v2 - URL générée par le controleur
        //On veut avoir l'URL de l'annonce d'id 5.
        // $url = $this->get('router')->generate(
        //     'demo_platform_view', // 1er argument : le nom de la route
        //     array('id' => 5)    // 2e argument : les valeurs des paramètres
        // );
        
        // $url = $this->get('router')->generate('demo_platform_view', array('id' => 8));
        // $url = $this->generateUrl('demo_platform_view', array('id' => 8));
        // $url vaut « /platform/advert/5 »
        
        // return new Response("L'URL de l'annonce d'id est : ".$url);
        
        // Index v3 - URL Absolue générée par le controleur
        // use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
        // $url = $this->get('router')->generate('oc_platform_home', array(), UrlGeneratorInterface::ABSOLUTE_URL);
    }
    
    // Routing : DemoPlatformBundle:Advert:view,
    // Routing Param : {id}
    public function viewAction($id, Request $request){
        // $id = paramètre contenu dans l'URL et traité via le routing
        // $request = Objet de la classe Request qui permet l'accès à la requete HTTP
        
        // Récupération du paramètre tag
        $tag = $request->query->get('tag');
        
        // Instanciation de la réponse
        $response = New Response();
        
        $content = "Affichage de l'annonde avec l'ID : " .$id. ", avec le tag : ".$tag. ". ";
        
        if ($request->isMethod('GET')){
            $content = $content . "La méthode d'appel est en " .$request->getMethod(). ".";
        }
        
        // V2: Simuler un 404
        // $response->setContent("Ceci est un 404");
        // $response->SetStatusCode(Response::HTTP_NOT_FOUND);
        
        $response->setContent($content);
        return $response;
    }
    
    // Routing : DemoPlatformBundle:Advert:viewSlug,
    // Routing Param : {year},{slug},{format}
    public function viewSlugAction($year, $slug, $_format){
        return new Response(
            "On pourrait afficher l'annonce correspondant au
            slug '".$slug."', créée en ".$year." et au format ".$_format."."
        );
    }
}