<?php
// src/Demo/PlatformBundle/Antispam/DemoAntispam.php

namespace Demo\PlatformBundle\Antispam;

class DemoAntispam
{
   private $mailer;
   private $locale;
   private $minLenght;
   
   /**
    * Constucteur de l'objet Antispam
    * @param : Swift_Mailer $mailer, String $locale, Int $minLenght
    * @return : Object Antispam
    */
    public function __construct(\Swift_Mailer $mailer, $locale, $minLenght){
        $this->mailer = $mailer;
        $this->locale = $locale;
        $this->minLenght = (int)$minLenght;
    }
   
   /**
   * Vérifie si le texte est un spam ou non
   *
   * @param string $text
   * @return bool
   */
  public function isSpam($text)
  {
    // = return IF strlen($text) < 50 True  
    return strlen($text) < $this->minLenght;
  }
}