<?php

namespace Demo\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CoreBundle\Controller\CoreController;

class ForumController extends Controller
{
    public function indexAction()
    {
        // On simule une tentative d'acces à une fonction de PlatformBundle 
        $listAdverts = $this->container->get('demo_core.platform')->getLastAdvertsAction(3);
        return $this->render('DemoForumBundle:Forum:index.html.twig',array('listAdverts' => $listAdverts));
    }
}
