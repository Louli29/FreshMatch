<?php

namespace App\form;

use App\Entity\ListIngrUser;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           /* ->add('email')
            //->add('roles')
            ->add('password')
            ->add('name')
            ->add('diet')
            ->add('allergy')
            ->add('listIngredient', EntityType::class, [
                'class' => ListIngrUser::class,
                'choice_label' => 'id',
            ])*/

            ->add('name', TextType::class, [
                'label' => 'Nom',
               'attr' => ['class' => 'form-control'],

           ])

            ->add('Email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('diet', TextType::class, [
                'label' => 'Votre régime alimentaire',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('allergy', TextType::class, [
                'label' => 'Vos allergies',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => User::class,
        ]);
    }

}
