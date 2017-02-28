<?php

// src/Demo/PlatformBundle/Controller/AdvertController.php

namespace Demo\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdvertController extends Controller
{
    public function indexAction()
    {
        $content = $this->get('templating')->render('DemoPlatformBundle:Advert:index.html.twig', array('nom' => 'Erwan'));
        return new Response($content);
    }
}