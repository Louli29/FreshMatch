<?php

namespace App\Form;

use App\Entity\ListIngrUser;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           // ->add('email')
           // ->add('roles')
           // ->add('password')
           // ->add('name')
           // ->add('diet')
           // ->add('allergy')
           // ->add('listIngredient', EntityType::class, [
           //     'class' => ListIngrUser::class,
           //     'choice_label' => 'id',
           // ])

        ->add('name', TextType::class, [
            'label' => 'Nom',
            'attr' => ['class' => 'form-control']
        ])
        ->add('email', EmailType::class, [
            'label' => 'E-mail',
            'attr' => ['class' => 'form-control']
        ])
        ->add('password', PasswordType::class, [
            'label' => 'Mot de passe',
            'attr' => ['class' => 'form-control']
        ])
        ->add('diet', TextType::class, [
            'label' => 'Votre régime alimentaire',
            'attr' => ['class' => 'form-control']
        ])
        ->add('allergy', TextType::class, [
            'label' => 'Vos allergies',
            'attr' => ['class' => 'form-control']
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
