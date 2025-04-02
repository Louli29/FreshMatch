<?php

namespace App\form;

use App\Entity\IngredientRecipe;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('name', TextType::class, [
                'label' => 'Nom de la recette',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('allergys', TextType::class, [
                'label' => 'Allergies',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('diet', TextType::class, [
                'label' => 'Régime alimentaire',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('ingredientRecipe', EntityType::class, [
                'class' => IngredientRecipe::class,
                'choice_label' => 'id',
                'multiple' => true,
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])

            ->add('step', TextareaType::class, [
                'label' => 'Étapes',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('time', IntegerType::class, [
                'label' => 'Temps (en minutes)',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('nbPerson', IntegerType::class, [
                'label' => 'Nombre de personnes',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('imageLink', UrlType::class, [
                'label' => 'Lien de l\'image',
                'attr' => ['class' => 'form-control'],
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
