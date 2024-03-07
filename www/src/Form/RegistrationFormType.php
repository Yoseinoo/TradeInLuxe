<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'formulaireCardFormInput',
                    'minLenght' => 2,
                    'maxLenght' => 180
                ],
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'formulaireCardFormLabel'
                ],
                'constraints' =>[
                    new Assert\NotBlank([
                        'message' => 'L\'adresse email est requise.',
                    ]),
                ]
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'formulaireCardFormInput',
                    'minLenght' => 2,
                    'maxLenght' => 25
                ],
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'formulaireCardFormLabel'
                ],
                'constraints' =>[
                    new Assert\NotBlank(
                        [
                            'message' => 'Le prénom est requis.',
                        ]
                    ),
                ]
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'formulaireCardFormInput',
                    'minLenght' => 2,
                    'maxLenght' => 25
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'formulaireCardFormLabel'
                ],
                'constraints' =>[
                    new Assert\NotBlank([
                        'message' => 'Le nom est requis.',
                    ]),
                ]
            ])
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
            ])
            ],
            'invalid_message' => 'Les mots de passe ne correspondent pas.'
            ])
            ->add('acceptTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => new Assert\IsTrue([
                    'message' => 'Vous devez accepter les conditions générales.',
                ]),
                'label' => 'J\'accepte les conditions générales d\'utilisation',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
                'attr' => [
                    'class' => 'formulaireCardFormSubmit',
                    'data-action' => 'authentification-form#disable'
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
