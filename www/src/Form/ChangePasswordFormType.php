<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'attr' => [
                    'class' => 'formulaireCardFormInput',
                    'data-authentification-form-target' => 'password' 
                ],
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'formulaireCardFormLabel'
                ],
            ],
            'second_options' => [
                'attr' => [
                    'class' => 'formulaireCardFormInput',
                    'data-authentification-form-target' => 'confirmPassword' 
                ],
                'label' => 'Confirmation du mot de passe',
                'label_attr' => [
                    'class' => 'formulaireCardFormLabel'
                ],
            ],
            'constraints' =>[
            new Assert\Length([
                'min' => 6,
                'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères.',
                'max' => 4096,
            ]),
            new Assert\Regex([
                'pattern' => '/(?=.*[a-z])/',
                'message' => 'Votre mot de passe doit contenir au moins une lettre minuscule.',
            ]),
            new Assert\Regex([
                'pattern' => '/(?=.*[A-Z])/',
                'message' => 'Votre mot de passe doit contenir au moins une lettre majuscule.',
            ]),
            new Assert\Regex([
                'pattern' => '/(?=.*\d)/',
                'message' => 'Votre mot de passe doit contenir au moins un chiffre.',
            ]),
            new Assert\Regex([
                'pattern' => '/(?=.*[\W_])/',
                'message' => 'Votre mot de passe doit contenir au moins un caractère spécial.',
            ]),
            ],
            'invalid_message' => 'Les mots de passe ne correspondent pas.'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'formulaireCardFormSubmit',
                    'data-action' => 'authentification-form#disable'
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
