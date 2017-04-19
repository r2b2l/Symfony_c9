<?php
// src/Demo/PlatformBundle/DataFixtures/ORM/LoadSkill.php

namespace Demo\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Demo\PlatformBundle\Entity\Skill;

class LoadSkill implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $names = array('PHP', 'Symfony', 'C++', 'Java', 'Photoshop', 'Excel');

    foreach ($names as $name) {
      // On crée la catégorie
      $skill= new Skill();
      $skill->setName($name);

      // On la persiste
      $manager->persist($skill);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}