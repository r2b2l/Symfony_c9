<?php
// src/Demo/PlatformBundle/Antispam/DemoAdvertPurger.php

namespace Demo\PlatformBundle\AdvertPurger;

use Doctrine\ORM\EntityRepository;
use Demo\PlatformBundle\Entity\Advert;

class DemoAdvertPurger
{
    
    /**
     * @var EntityManagerInterface
     */
    private $em;
    
    public function __contruct(\Doctrine\ORM\EntityManager $em){
        $this->em = $em;
    }
    
    public function getEntityManager(){
        return $this->em;
    }
    
    public function setEntityManager(\Doctrine\ORM\EntityManager $em){
        $this->em = $em;
        return $this;
    }
    
    
    /**
     * Param : limit : limite de jour avant la purge
     */
    public function purge($limit){
        // var_dump($this);
        $advertRepository = $this->em->getRepository('DemoPlatformBundle:Advert');
        
        $date = new \DateTime($limit.'days ago');
        
        $listAdverts = $advertRepository->getAdvertsWithNoApplicationsAndDateLowerThanParam($date);
        var_dump($listAdverts);
        
        foreach($listAdverts as $advert){
            $skills = $advert->getSkills();
            foreach ($skills as $skill){
                // Suppression des Skills de l'advert
                // Ceci remove de l'objet advert mais remove pas de la table advertSkill : Utiliser l'entity manager pour qu'il gère toute la suppression
                // $advert->removeSkill($skill);
                $this->em->remove($skill);
            }
            // Suppression de l'advert
            $this->em->remove($advert);
        }
        $this->em->flush();
    }
}