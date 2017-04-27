<?php

// src/OC/PlatformBundle/DoctrineListener/ApplicationCreationListener.php

namespace Demo\PlatformBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Demo\PlatformBundle\Email\ApplicationMailer;
use Demo\PlatformBundle\Entity\Application;

class ApplicationCreationListener{
    
    /**
     * @var ApplicationMailer
     */
     private $applicationMailer;
     
     public function __construct(ApplicationMailer $applicationMailer2){
         $this->applicationMailer = $applicationMailer2;
     }
     
     public function postPersist(LifecycleEventArgs $args){
         // LifecycleEventArgs a 2 methods : getObject et getObjectManager (pour obtenir l'Entity Manager)
         $entity= $args->getObject();
         
         // On envoie le mail que pour les candidatures
         if(!$entity instanceof Application){
             return;
         }
        //  try{
            $this->applicationMailer->sendNewNotification($entity);    
        //  }
         
        //  return;
     }
}