<?php

namespace App\Form;

use App\Entity\IngredientRecipe;
use App\Entity\Recipe;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('duree')
            ->add('nom')
            ->add('description')
            ->add('etape')
            ->add('nbPersonne')
            ->add('ingredientRecette', EntityType::class, [
                'class' => IngredientRecipe::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('utilisateur', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
