<?php

namespace App\Form;

use App\Entity\Tournoi;
use App\Entity\Plateformes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TournoiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateDebut', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateFin', DateTimeType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('nbParticipants', IntegerType::class, [
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('plateforme', EntityType::class, [
                'class' => Plateformes::class,
                'choice_label' => 'libPlateforme',
            ])
            ->add('catTournoi', EntityType::class, [
                'class' => \App\Entity\CatTournoi::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie de tournoi',
                'required' => false,
            ])
            ->add('participants', EntityType::class, [
                'class' => \App\Entity\Participant::class,
                'choice_label' => 'prenom', // Or a custom label like 'prenom' . ' ' . 'nom'
                'label' => 'Participants',
                'multiple' => true,
                'expanded' => false, // Dropdown (true for checkboxes)
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tournoi::class,
        ]);
    }
}
