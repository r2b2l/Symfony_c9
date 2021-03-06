<?php

namespace Demo\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class)
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('author', TextType::class)
            ->add('email', TextType::class)
            ->add('published', CheckboxType::class, array('required' => false)) // Required false indique que le champ n'est pas obligatoire d'etre renseigné (champs facultatifs de l'entity)
            ->add('image', ImageType::class)
            /*
            * Rappel :
            ** - 1er argument : nom du champ, ici « categories », car c'est le nom de l'attribut
            ** - 2e argument : type du champ, ici « CollectionType » qui est une liste de quelque chose
            ** - 3e argument : tableau d'options du champ
            */
            ->add('categories', CollectionType::class, array(
                'entry_type' => CategoryType::class, // Précision sur le type d'objet dans la collection
                'allow_add' => true, // Option
                'allow_delete' => true // Option
                ))
            ->add('save', SubmitType::class)
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Demo\PlatformBundle\Entity\Advert'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'demo_platformbundle_advert';
    }


}
