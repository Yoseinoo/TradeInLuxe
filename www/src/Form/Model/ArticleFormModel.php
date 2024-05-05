<?php

namespace App\Form\Model;

use App\Entity\Etat;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleFormModel
{
    
    #[Assert\NotBlank(message:'La description est requise.')]
    #[Assert\Length(min:2, max:25, minMessage: 'La description doit comporter au moins {{ limit }} caractères.',maxMessage: 'La description doit comporter moins de {{ limit }} caractères.')]
    public string $description;
    #[Assert\NotBlank(message:'L\'état est requis.')]
    public Etat $etat;
    #[Assert\NotBlank(message:'La taille est requise.')]
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


    public function setPhotos(array $photos = null)
    {
        $this->photos = $photos;
    }

  
}
