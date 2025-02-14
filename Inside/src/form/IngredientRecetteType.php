<?php

namespace App\form;

use App\Entity\Ingredient;
use App\Entity\IngredientRecette;
use App\Entity\Recette;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngredientRecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantite')
            ->add('remplacable')
            ->add('unite')
            ->add('ingredient', EntityType::class, [
                'class' => Ingredient::class,
                'choice_label' => 'id',
            ])
            ->add('recette', EntityType::class, [
                'class' => Recette::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => IngredientRecette::class,
        ]);
    }
}
