<?php

namespace App\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;


class ArticlePhotoModel
{
    #[Assert\NotBlank(message:'Les photos sont requises.')]
    #[Assert\Image(
        mimeTypes: ["image/jpeg", "image/png", "image/avif"],
        mimeTypesMessage: "Veuillez télécharger une image valide (JPEG, PNG ou AVIF)"
    )]
    public $photo;

  
}
