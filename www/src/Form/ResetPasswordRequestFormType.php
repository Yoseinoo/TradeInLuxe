<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ResetPasswordRequestFormType extends AbstractType
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
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'L\'adresse email est requise.',
                    ]),
                    new Assert\Length([
                        'min' => 2,
                        'minMessage' => 'Votre email doit comporter moins de {{ limit }} caractères.',
                        'max' => 180,
                        'maxMessage' => 'Votre email doit comporter au moins {{ limit }} caractères.'
                    ]),
                    new Assert\Email([
                        'message' => 'Merci de mettre un email valide'
                    ])
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
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
