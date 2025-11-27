<?php

namespace App\Form;

use App\Entity\JeuVideo;
use App\Entity\Genre;
use App\Entity\Marque;
use App\Entity\Pegi;
use App\Entity\Plateformes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JeuVideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('refJeu', TextType::class, [
                'label' => 'Référence du jeu',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom du jeu',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('prix', MoneyType::class, [
                'label' => 'Prix',
                'currency' => 'EUR',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('dateParution', DateType::class, [
                'label' => 'Date de parution',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'libGenre',
                'label' => 'Genre',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('pegi', EntityType::class, [
                'class' => Pegi::class,
                'choice_label' => 'descPegi',
                'label' => 'Classification PEGI',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('plateforme', EntityType::class, [
                'class' => Plateformes::class,
                'choice_label' => 'libPlateforme',
                'label' => 'Plateforme',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('marque', EntityType::class, [
                'class' => Marque::class,
                'choice_label' => 'nomMarque',
                'label' => 'Marque',
                'attr' => ['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JeuVideo::class,
        ]);
    }
}
