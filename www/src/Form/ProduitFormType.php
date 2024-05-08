<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Form\Model\ProduitFormModel;
use App\Repository\CategorieRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProduitFormType extends AbstractType
{

    public function __construct(
        private CategorieRepository $categorieRepository,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'attr' => [
                'class' => 'formulaireCardFormInput',
                'minLenght' => 2,
                'maxLenght' => 35
            ],
            'label' => 'Nom de l\'article',
            'label_attr' => [
                'class' => 'formulaireCardFormLabel'
            ],
        ])
        ->add('categorie', EntityType::class,[
            'label' => 'Catégorie',
            'label_attr' => [
                'class' => 'formulaireCardFormLabel'
            ],
            'attr' => [
                'class' => 'formulaireCardFormInput',
            ],
            'class' => Categorie::class,
            'required' => true,
            'choice_label' => fn (Categorie $categorie) => $categorie->getName(),
            'placeholder' => '-- Merci de sélectionner --',
            'choices' => $this->categorieRepository->getAll('deleted=false&isEnabled=true'),
        ])
        ->add('marque', TextType::class, [
            'attr' => [
                'class' => 'formulaireCardFormInput',
                'minLenght' => 2,
                'maxLenght' => 35
            ],
            'label' => 'Marque',
            'label_attr' => [
                'class' => 'formulaireCardFormLabel'
            ],
        ])
        ->add('description', TextareaType::class, [
            'attr' => [
                'class' => 'formulaireCardFormInput',
                'minLenght' => 5,
                'maxLenght' => 1000
            ],
            'label' => 'Description détaillée',
            'label_attr' => [
                'class' => 'formulaireCardFormLabel'
            ],
        ])
        ->add('taille', TextType::class, [
            'attr' => [
                'class' => 'formulaireCardFormInput',
                'minLenght' => 1,
                'maxLenght' => 5,
                'placeholder' => 'ex: 36,37 ou XS, S...'
            ],
            'label' => 'Taille',
            'label_attr' => [
                'class' => 'formulaireCardFormLabel'
            ],
        ])
        ->add('couleur', TextType::class, [
            'attr' => [
                'class' => 'formulaireCardFormInput',
                'minLenght' => 1,
                'maxLenght' => 10,
            ],
            'label' => 'Couleur',
            'label_attr' => [
                'class' => 'formulaireCardFormLabel'
            ],
        ])
        ->add('genre', ChoiceType::class, [
            'label' => 'Genre',
            'label_attr' => [
                'class' => 'formulaireCardFormLabel'
            ],
            'attr' => [
                'class' => 'formulaireCardFormInput',
            ],
            'required' => true,
            'placeholder' => '-- Merci de sélectionner --',
            'choices' => [
                'Homme' => 'Homme',
                'Femme' => 'Femme',
                'Mixte' => 'Mixte'
            ]
        ])
        ->add('photos', CollectionType::class, [
            'entry_type' => ArticlePhotosFormType::class,
            'by_reference' => false,
            'entry_options' =>['label' => false],
            'allow_add' =>true,
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
            'data_class' => ProduitFormModel::class,
        ]);
    }
}
