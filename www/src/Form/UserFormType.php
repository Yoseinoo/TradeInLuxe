<?php

namespace App\Form;

use App\Form\Model\UserFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('pathImage', FileType::class, [
            'attr' => [
                'class' => 'formulaireCardFormInput',
            ],
            'label' => 'Photo de profil',
            'label_attr' => [
                'class' => 'formulaireCardFormLabel'
            ],
            'required' => false
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
        ])
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
            ])
            ->add('street', TextType::class, [
                'attr' => [
                    'class' => 'formulaireCardFormInput',
                    'minLenght' => 2,
                    'maxLenght' => 40
                ],
                'label' => 'Adresse (ex: 13 rue Jean-Paul)',
                'label_attr' => [
                    'class' => 'formulaireCardFormLabel'
                ],
            ])
            ->add('postcode', TextType::class, [
                'attr' => [
                    'class' => 'formulaireCardFormInput',
                    'minLenght' => 5,
                    'maxLenght' => 5
                ],
                'label' => 'Code Postal',
                'label_attr' => [
                    'class' => 'formulaireCardFormLabel'
                ],
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'formulaireCardFormInput',
                    'minLenght' => 2,
                    'maxLenght' => 40
                ],
                'label' => 'Ville',
                'label_attr' => [
                    'class' => 'formulaireCardFormLabel'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer mes informations',
                'attr' => [
                    'class' => 'formulaireCardFormSubmit',
                    'data-action' => 'authentification-form#disable'
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' =>UserFormModel::class,
        ]);
    }
}
