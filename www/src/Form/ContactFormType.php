<?php

namespace App\Form;

use App\Entity\SubjectContact;
use App\Form\Model\ContactFormModel;
use App\Repository\SubjectContactRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactFormType extends AbstractType
{
    public function __construct(
        private SubjectContactRepository $subjectContactRepository,
    ) {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('service', EntityType::class,[
                'label' => 'Sujet',
                'label_attr' => [
                    'class' => 'formulaireCardFormLabel'
                ],
                'attr' => [
                    'class' => 'formulaireCardFormInput',
                ],
                'class' => SubjectContact::class,
                'required' => true,
                'choice_label' => fn (SubjectContact $subjectContact) => $subjectContact->getSujet(),
                'choice_value' => 'email',
                'placeholder' => '-- Merci de sélectionner --',
                'choices' => $this->subjectContactRepository->getAll('deleted=false&isEnabled=true&order=desc'),
            ])
            ->add('firstname', TextType::class, [
                'empty_data' => '',
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
            ->add('email', EmailType::class, [
                'empty_data' => '',
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
            ->add('message', TextareaType::class, [
                'empty_data' => '',
                'attr' => [
                    'class' => 'formulaireCardFormInput',
                    'minLenght' => 3,
                    'maxLenght' => 300
                ],
                'label' => 'Votre message',
                'label_attr' => [
                    'class' => 'formulaireCardFormLabel'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'formulaireCardFormSubmit',
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactFormModel::class,
        ]);
    }
}
