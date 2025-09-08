<?php

namespace App\Form;

use App\Entity\Interventions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterventionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', TextType::class)
            ->add('nomClient', TextType::class)
            ->add('prenomClient', TextType::class)
            ->add('adresseClient', TextType::class)
            ->add('telephoneClient', TextType::class)
            ->add('emailClient', TextType::class)
            ->add('description', TextareaType::class)
            ->add('dateIntervention', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'En cours' => 'en cours',
                    'Validée' => 'validée',
                    'Terminée' => 'terminée',
                ],
            ])
            ->add('technicien', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Interventions::class,
        ]);
    }
}
