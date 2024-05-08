<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Taille;
use App\Repository\EtatRepository;
use App\Form\Model\ArticleFormModel;
use App\Repository\TailleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ArticleFormType extends AbstractType
{

    public function __construct(
        private EtatRepository $etatRepository,
        private TailleRepository $tailleRepository,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $idCategorie=$options['categorie'];
        $builder
  
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
        ->add('taille', EntityType::class,[
            'label' => 'Taille',
            'label_attr' => [
                'class' => 'formulaireCardFormLabel'
            ],
            'attr' => [
                'class' => 'formulaireCardFormInput',
            ],
            'class' => Taille::class,
            'required' => true,
            'choice_label' => fn (Taille $taille) => $taille->getName(),
            'choice_value' => 'name',
            'placeholder' => '-- Merci de sélectionner --',
            'choices' => $this->tailleRepository->getAll('categorie='.$idCategorie.'&deleted=false&isEnabled=true&orderby=rank'),
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
        ->add('etat', EntityType::class,[
            'label' => 'Etat',
            'label_attr' => [
                'class' => 'formulaireCardFormLabel'
            ],
            'attr' => [
                'class' => 'formulaireCardFormInput',
            ],
            'class' => Etat::class,
            'required' => true,
            'choice_label' => fn (Etat $etat) => $etat->getName(),
            'choice_value' => 'name',
            'placeholder' => '-- Merci de sélectionner --',
            'choices' => $this->etatRepository->getAll('deleted=false&isEnabled=true&orderby=rank'),
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
            'data_class' => ArticleFormModel::class,
            'categorie' => null
        ]);
    }
}
