<?php

namespace App\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ContactFormModel
{
    #[Assert\NotBlank(message:'Merci de choisir le sujet.')]
    public $service;

    #[Assert\NotBlank(message:'Le prénom est requis.')]
    #[Assert\Length(min:2, max:25, minMessage: 'Votre prénom doit comporter au moins {{ limit }} caractères.',maxMessage: 'Votre prénom doit comporter moins de {{ limit }} caractères.')]
    public string $firstname = '';

    #[Assert\NotBlank(message:'L\'adresse email est requise.')]
    #[Assert\Email(message:'Merci de mettre un email valide')]
    #[Assert\Length(min:2, max:180, minMessage: 'Votre email doit comporter au moins {{ limit }} caractères.',maxMessage: 'Votre email doit comporter moins de {{ limit }} caractères.')]
    public string $email = '';

    #[Assert\NotBlank(message:'Le message est requis.')]
    #[Assert\Length(min:3, max:300, minMessage:'Votre message doit comporter au moins {{ limit }} caractères.', maxMessage:'Votre message doit comporter moins de {{ limit }} caractères.')]
    public string $message = '';
}