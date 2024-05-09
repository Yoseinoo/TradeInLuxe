<?php

namespace App\Form;

use App\Form\Model\ArticlePhotoModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Image;

class ArticlePhotosFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('photo', FileType::class, [
                'attr' => [
                    'class' => 'formulaireCardFormInput',
                ],
                'label' => 'Photo ',
                'label_attr' => [
                    'class' => 'formulaireCardFormLabel'
                ],
                'required' =>  $options['required'],
                'constraints' => [
                    new Image([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/avif',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG ou AVIF).',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArticlePhotoModel::class,
            'required' => true, 
        ]);
    }
}
