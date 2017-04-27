<?php

// src/Demo/PlatformBundle/Antispam/DemoAntispam.php

namespace Demo\PlatformBundle\Email;

use Demo\PlatformBundle\Entity\Application;

class ApplicationMailer{
    /**
     * @var \Swift_Mailer
     */
     private $mailer;
     
     public function __construct(\Swift_Mailer $mailer){
         $this->mailer = $mailer;
     }
     
     public function sendNewNotification(Application $application){
         $message = new \Swift_Message('Nouvelle candidature','Vous avez reçu une nouvelle candidature.');
         
         $message->addTo($application->getAdvert()->getEmail()) // Ici il faudrait un mail, mais on prends l'auteur
         ->addFrom('admin@xxxxxxxxxx.com');
         
         $this->mailer->send($message);
     }
}