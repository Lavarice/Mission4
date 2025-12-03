<?php

namespace App\Form;

use App\Entity\CatTournoi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CatTournoiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la catégorie',
                'attr' => ['class' => 'form-control']
            ])
            ->add('tournois', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, [
                'class' => \App\Entity\Tournoi::class,
                'choice_label' => 'nom',
                'label' => 'Tournois associés',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'by_reference' => false, // Important for OneToMany inverse side
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CatTournoi::class,
        ]);
    }
}
