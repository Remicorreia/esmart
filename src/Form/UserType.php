<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $client = $options["data"]; 
        /*  
        $options["data"] permet de recuperer l'objet utilisé pour generer
        le formulaire : dans le controleur
        $form = $this->createForm(ClientType::class, $client);
        */

        $builder
        ->add('nom')
        ->add('prenom')
        ->add("civilite", ChoiceType::class , [
            "label" => "Civilité",
            "choices" =>[
                "Mme" => "f",
                "M." => "h",
            ],
            "expanded" => true
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
