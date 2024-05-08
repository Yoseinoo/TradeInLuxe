<?php

namespace App\Form\Model;

use App\Entity\Etat;
use Symfony\Component\Validator\Constraints as Assert;

class PropositionFormModel
{
    #[Assert\NotBlank(message:'Le nom est requis.')]
    #[Assert\Length(min:2, max:35, minMessage: 'Le nom doit comporter au moins {{ limit }} caractères.',maxMessage: 'Le nom doit comporter moins de {{ limit }} caractères.')]
    public string $name;
    #[Assert\NotBlank(message:'La marque est requise.')]
    #[Assert\Length(min:2, max:35, minMessage: 'La marque doit comporter au moins {{ limit }} caractères.',maxMessage: 'La marque doit comporter moins de {{ limit }} caractères.')]
    public string $marque;
    #[Assert\NotBlank(message:'La description est requise.')]
    #[Assert\Length(min:5, max:1000, minMessage: 'La description doit comporter au moins {{ limit }} caractères.',maxMessage: 'La description doit comporter moins de {{ limit }} caractères.')]
    public string $description;
    #[Assert\NotBlank(message:'L\'état est requis.')]
    public Etat $etat;
    #[Assert\NotBlank(message:'La taille est requise.')]
    #[Assert\Length(min:1, max:5, minMessage: 'La taille doit comporter au moins {{ limit }} caractères.',maxMessage: 'La taille doit comporter moins de {{ limit }} caractères.')]
    public $taille;
    #[Assert\NotBlank(message:'Les photos sont requises.')]
    public $photos;


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setEtat(?Etat $etat): void
    {
        $this->etat = $etat;
    }

    public function setPhotos(array $photos = null)
    {
        $this->photos = $photos;
    }

  
}
