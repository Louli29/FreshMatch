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

use App\Enums\Diet;
use App\Enums\Allergy;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('Email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'Mot de passe',
                'attr' => ['class' => 'form-control', 'autocomplete' => 'new-password'],
            ])
            ->add('diet', ChoiceType::class, [
                'label' => 'Votre régime alimentaire',
                'choices' => array_combine(
                    array_map(fn($d) => $d->value, Diet::cases()),
                    Diet::cases()
                ),
                'choice_label' => fn($choice) => $choice->value,
                'expanded' => true,
                'multiple' => false,
                'required' => false,
            ])
            ->add('allergy', ChoiceType::class, [
                'label' => 'Vos allergies',
                'choices' => array_combine(
                    array_map(fn($a) => $a->value, Allergy::cases()),
                    Allergy::cases()
                ),
                'choice_label' => fn($choice) => $choice->value,
                'expanded' => true,
                'multiple' => true,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => User::class,
        ]);
    }
}
