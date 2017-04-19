<?php

// src/Demo/PlatformBundle/Controller/AdvertController.php

namespace Demo\PlatformBundle\Controller;

use Demo\PlatformBundle\Entity\Advert;
use Demo\PlatformBundle\Entity\AdvertSkill;
use Demo\PlatformBundle\Entity\Image;
use Demo\PlatformBundle\Entity\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CoreBundle\Controller\CoreController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

// Il faut étendre le contrôleur pour accéder aux fonctions
class AdvertController extends Controller
{
    // Routing : DemoPlatformBundle:Advert:index
    // Routing Param : {page}
    public function indexAction($page){
        // Index v1
        // $content = $this->get('templating')->render('DemoPlatformBundle:Advert:index.html.twig', array('nom' => 'Erwan'));
        // return new Response($content);
        
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
        
        // Index V4 officielle
        // Si numero page >= 1 (une annonce doit être > 0)
        if ($page < 1){
            // On déclenche un NotFoundHttpException => 404
            throw new NotFoundHttpException('Page "'. $page .'" inexistante.');
        }
        
        // Récupération de la liste des annonces, a passer au Template
        // Liste d'annonces en dur
        $listAdverts = array(
          array(
            'title'   => 'Recherche développpeur Symfony',
            'id'      => 1,
            'author'  => 'Alexandre',
            'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
            'date'    => new \Datetime()),
          array(
            'title'   => 'Mission de webmaster',
            'id'      => 2,
            'author'  => 'Hugo',
            'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
            'date'    => new \Datetime()),
          array(
            'title'   => 'Offre de stage webdesigner',
            'id'      => 3,
            'author'  => 'Mathieu',
            'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
            'date'    => new \Datetime())
        );
        
        // Appel au Template
        return $this->render('DemoPlatformBundle:Advert:index.html.twig'
        ,array('listAdverts' => $listAdverts)
        );
    }
    
    // Routing : DemoPlatformBundle:Advert:view
    // Routing Param : {id}
    public function viewAction($id, Request $request){
        // $id = paramètre contenu dans l'URL et traité via le routing
        // $request = Objet de la classe Request qui permet l'accès à la requete HTTP
        
        // Paramétrage de la session
        // $session = $request->getSession();
        // $session->set('user_id', 91);
        // $userId = $session->get('user_id');
        
        // Récupération du paramètre tag
        // $tag = $request->query->get('tag');
        
        
        // V5 
        // $advert => ecrit en brut, plus tard en BDD
        // $advert = array(
        //       'title'   => 'Recherche développpeur Symfony 3',
        //       'id'      => $id,
        //       'author'  => 'Alexandre',
        //       'content' => 'Nous recherchons un développeur Symfony 3 débutant sur Lyon. Blabla…',
        //       'date'    => new \Datetime()            
        //     );
        
        // Definition de l'Entity Manager
        $em = $this->getDoctrine()->getManager();
        
        // Récupération du répository
        $repository = $em->getRepository('DemoPlatformBundle:Advert');
        
        // Récupération de l'entité avec l'id passée en param
        $advert = $repository->find($id);
        
        // $advert est donc une instance de Demo\PlatformBundle\Entity\Advert
        // ou null si l'id $id  n'existe pas, d'où ce if :
        if (null === $advert) {
          throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
        
        // On récupère les candidatures à l'annonce
        // $listApplications = $em->getRepository('DemoPlatformBundle:Application')->findBy(array('advert' => $advert));
        
        // V2 récupération des candidatures grace à la relation bidirectionnelle
        $listApplications = $advert->getApplications();
        
        // On récupère les Skills
        $listAdvertSkills = $em->getRepository('DemoPlatformBundle:AdvertSkill')->findBy(array('advert' => $advert));
        
        
        // Envoi a la vue
        return $this->render('DemoPlatformBundle:Advert:view.html.twig', array(
            'advert' => $advert,
            'listApplications' => $listApplications,
            'listAdvertSkills' => $listAdvertSkills
        ));
        
        // Instanciation de la réponse
        //$response = New Response();
        
        // $content = "Affichage de l'annonde avec l'ID : " .$id. ", avec le tag : ".$tag. ". ";
        
        // if ($request->isMethod('GET')){
        //     $content = $content . "La méthode d'appel est en " .$request->getMethod(). ".";
        // }
        
        // Update de la réponse
            //$response->setContent($content);
        
        
        // V2: Simuler un 404
        
        // $response->setContent("Ceci est un 404");
        // $response->SetStatusCode(Response::HTTP_NOT_FOUND);
        
        // V3: Redirection
        
        // return $this->redirectToRoute('demo_platform_home');
        
        // V4: Changer le type de réponse
        
        // Créons nous-mêmes la réponse en JSON, grâce à la fonction json_encode()
        //$response = new Response(json_encode(array('id' => $id)));
        // Ici, nous définissons le Content-type pour dire au navigateur
        // que l'on renvoie du JSON et non du HTML
        //$response->headers->set('Content-Type', 'application/json');
        // V4.1
        //return new JsonResponse(array('id' => $id));
        
        
        // Envoi de la réponse
        //return $response;
    }
    
    // Routing : DemoPlatformBundle:Advert:add
    // Routing Param : N/A
    public function addAction(Request $request){
        // $request = Objet de la classe Request qui permet l'accès à la requete HTTP
        
        // Récupération du service Antispam
        // $antispam = $this->container->get('demo_platform.antispam');
        // $text = '...';
        // if ($antispam->isSpam($text)) {
        //   throw new \Exception('Votre message a été détecté comme spam !');
        // }
        
        // throw new \Exception('On va éviter de spammer la création d\'Adverts bidon :p , ça enregistre en BDD ;) ');
        
        
        // Création de l'entité
        $advert = new Advert();
        $advert->setTitle('Une annonce');
        $advert->setAuthor('Le grand boss');
        $advert->setContent('Nous recrutons quelqu\'un, pas besoin de préciser pourquoi');
        
        // Creation de l'entité Image
        $image = new Image();
        $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
        $image->setAlt('Job de rêve');
        
        $advert->setImage($image);
        
        // Création des candidatures
        $application1 = new Application();
        $application1->setAuthor('Marine');
        $application1->setContent('J\'ai toutes les compétences.');
        
        $application2 = new Application();
        $application2->setAuthor('Pierre');
        $application2->setContent('Je suis motivay.');

        $application1->setAdvert($advert);
        $application2->setAdvert($advert);
        
        // Récupération de l'Entity Manager
        $em = $this->getDoctrine()->getManager();
        
        // Récupération des Skills
        $listSkills = $em->getRepository('DemoPlatformBundle:Skill')->findAll();
        
        foreach($listSkills as $skill){
            // Création de la relation entre l'Advert et le Skill
            $advertSkill = new AdvertSkill();
            // Liaison à l'Advert
            $advertSkill->setAdvert($advert);
            // Liaison du Skill de la boucle
            $advertSkill->setSkill($skill);
            // Ajout du niveau : Par défaut on va dire Expert :D
            $advertSkill->setLevel('Expert');
            // Persistance par Doctrine
            $em->persist($advertSkill);
        }
        
        // Persistance de l'entité
        // Si on n'avait pas défini le cascade={"persist"} de l'image dans Advert, on devrait persister egalement l'entité $image
        $em->persist($advert);
        
        // Étape 1 ter : pour cette relation pas de cascade lorsqu'on persiste Advert, car la relation est
        // définie dans l'entité Application et non Advert. On doit donc tout persister à la main ici.
        $em->persist($application1);
        $em->persist($application2);
  
      
        // Test de récupération d'une annonce et modif de la date pour tester le Strart transaction du Flush d'Entity Manager
        // A commenter en suivant ;)
        // // Advert 2 est une entité Doctrine, on aura même pas besoin de faire un persist dessus :p
        // $advert2 = $em->getRepository('DemoPlatformBundle:Advert')->find(1);
        //   // Modif de la date
        // $advert2->setDate(new \Datetime());
        
        // Flush (enregistre en BDD) ce qui a été persisté précédemment
        $em->flush();
        
        // Si la requête est en POST, c'est que le visiteur a soumis le formulaire
        if ($request->isMethod('POST')) {
            // Ici, creation et gestion du formulaire
            $session = $request->getSession();
            // Message Flash de l'enregistrement de l'annonce
            $session->getFlashBag()->add('notice','Annonce bien enregistrée');
            
            // Redirection vers la page de visualisation
            return $this->redirectToRoute('demo_platform_view', array('id' => $advert->getId()));
        }
        
        // Si on n'est pas en POST, alors on affiche le formulaire
        return $this->render('DemoPlatformBundle:Advert:add.html.twig', array('advert' => $advert));
    }
    
    // Routing : DemoPlatformBundle:Advert:edit
    // Routing Param : {id}
    public function editAction($id, Request $request){
        
        $em = $this->getDoctrine()->getManager();
        
        // Ici, récupération de l'annonce de l'$id
        $advert = $em->getRepository('DemoPlatformBundle:Advert')->find($id);
        
        if (null === $advert){
            throw new NotFoundHttpException("L'annonce " .$id. " n'a pas été trouvée");
        }
        
        // On récupère toutes les catégories
        $listCategories = $em->getRepository('DemoPlatformBundle:Category')->findAll();
        
        // On les lie à l'annonce
        foreach($listCategories as $category){
            $advert->addCategory($category);
        }

        // Pour persister le changement dans la relation, il faut persister l'entité propriétaire  
        // Ici, Advert est le propriétaire, donc inutile de la persister car on l'a récupérée depuis Doctrine
    
        // Étape 2 : On déclenche l'enregistrement
        $em->flush();

        
        // Tutoriel a garder
        // Si la requête est en POST, c'est que le visiteur a soumis le formulaire
        // if ($request->isMethod('POST')) {
        //     // Ici, creation et gestion du formulaire
        //     $session = $request->getSession();
        //     // Message Flash de la modification de l'annonce
        //     $session->getFlashBag()->add('notice','Annonce bien modifiée');
            
        //     // Redirection vers la page de visualisation
        //     return $this->redirectToRoute('demo_platform_view', array('id' => 5));
        // }
        // Si on n'est pas en POST, alors on affiche le formulaire
    
        return $this->render('DemoPlatformBundle:Advert:edit.html.twig', array(
          'advert' => $advert
        ));
    }
    
    
    // Routing : DemoPlatformBundle:Advert:delete
    // Routing Param : {id}
    public function deleteAction($id){
        
        $em = $this->getDoctrine()->getManager();
        // ici, récupération de l'annonce de l'$id
        $advert = $em->getRepository('DemoPlatformBundle:Advert')->find($id);
        
        if (null === $advert){
            throw new NotFoundHttpException("L'annonce " .$id. " n'a pas été trouvée");
        }
        
        // Boucle sur les catégories pour les supprimer
        foreach ($advert->getCategories() as $category){
            $advert->removeCategory($category);
        }

        // Pour persister le changement dans la relation, il faut persister l'entité propriétaire
        // Ici, Advert est le propriétaire, donc inutile de la persister car on l'a récupérée depuis Doctrine
    
        // On déclenche la modification
        $em->flush();        
        
        // Ici, la suppression de l'annonce
        // $advert = array(
        //   'title'   => 'Recherche développpeur Symfony',
        //   'id'      => $id,
        //   'author'  => 'Alexandre',
        //   'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
        //   'date'    => new \Datetime()
        // );
        return $this->render('DemoPlatformBundle:Advert:delete.html.twig', array(
                'advert' => $advert
            ));
    }
    
    // Affiche les dernières nouvelles dans le menu du site
    // Param : Limite d'annonces
    public function menuAction($limit){
        // On fixe en dur une liste ici, bien entendu par la suite
        // on la récupérera depuis la BDD !
        $listAdverts = array(
          array('id' => 2, 'title' => 'Recherche développeur Symfony'),
          array('id' => 5, 'title' => 'Mission de webmaster'),
          array('id' => 9, 'title' => 'Offre de stage webdesigner')
        );
    
        return $this->render('DemoPlatformBundle:Advert:menu.html.twig', array(
          // Tout l'intérêt est ici : le contrôleur passe
          // les variables nécessaires au template !
          'listAdverts' => $listAdverts
        ));
    }    
    
    // Retourne les dernières annonces du site
    // Param : Limite d'annonces    
    public function getLastAdvertsAction($limit){
        // On fixe en dur une liste ici, bien entendu par la suite
        // on la récupérera depuis la BDD !
        $listAdverts = array(
          array('id' => 2, 'title' => 'Recherche développeur Symfony'),
          array('id' => 5, 'title' => 'Mission de webmaster'),
          array('id' => 9, 'title' => 'Offre de stage webdesigner')
        );
        return $listAdverts;
    }
    
    // Pour le test
    // Routing : DemoPlatformBundle:Advert:editImage
    // Routing Param : {id}
    public function editImageAction($id){
        $em = $this->getDoctrine()->getManager();

      // On récupère l'annonce
      $advert = $em->getRepository('DemoPlatformBundle:Advert')->find($id);
    
      // On modifie l'URL de l'image par exemple
      $advert->getImage()->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
      
        // On n'a pas besoin de persister l'annonce ni l'image.
        // Rappelez-vous, ces entités sont automatiquement persistées car
        // on les a récupérées depuis Doctrine lui-même
        // On déclenche la modification
        $em->flush();
        
        return new Response('OK');        
    }
    
    // Pour le test
    // Routing : DemoPlatformBundle:Advert:viewSlug,
    // Routing Param : {year},{slug},{format}
    public function viewSlugAction($year, $slug, $_format){
        return new Response(
            "On pourrait afficher l'annonce correspondant au
            slug '".$slug."', créée en ".$year." et au format ".$_format."."
        );
    }
}