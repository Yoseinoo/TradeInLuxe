<?php

namespace App\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class UserFormModel
{
    #[Assert\NotBlank(message:'Le prénom est requis.')]
    #[Assert\Length(min:2, max:25, minMessage: 'Votre prénom doit comporter au moins {{ limit }} caractères.',maxMessage: 'Votre prénom doit comporter moins de {{ limit }} caractères.')]
    public string $firstname;
    #[Assert\NotBlank(message:'Le nom est requis.')]
    #[Assert\Length(min:2, max:25, minMessage: 'Votre nom doit comporter au moins {{ limit }} caractères.',maxMessage: 'Votre nom doit comporter moins de {{ limit }} caractères.')]
    public string $lastname;
    #[Assert\NotBlank(message:'L\'adresse email est requise.')]
    #[Assert\Email(message:'Merci de mettre un email valide')]
    #[Assert\Length(min:2, max:180, minMessage: 'Votre email doit comporter au moins {{ limit }} caractères.',maxMessage: 'Votre email doit comporter moins de {{ limit }} caractères.')]
    public string $email;
    #[Assert\NotBlank(message:'L\'adresse est requise.')]
    #[Assert\Length(min:2, max:40, minMessage: 'Votre adresse doit comporter au moins {{ limit }} caractères.',maxMessage: 'Votre adresse doit comporter moins de {{ limit }} caractères.')]
    public string $street;
    #[Assert\NotBlank(message:'Le code postal est requis.')]
    #[Assert\Length(min:5, max:5, minMessage: 'Votre code postal doit comporter au moins {{ limit }} caractères.',maxMessage: 'Votre code postal doit comporter moins de {{ limit }} caractères.')]
    public string $postcode;
    #[Assert\NotBlank(message:'La ville est requise.')]
    #[Assert\Length(min:2, max:40, minMessage: 'Votre ville doit comporter au moins {{ limit }} caractères.',maxMessage: 'Votre ville doit comporter moins de {{ limit }} caractères.')]
    public string $city;
 
    #[Assert\Image(
        mimeTypes: ["image/jpeg", "image/png", "image/avif"],
        mimeTypesMessage: "Veuillez télécharger une image valide (JPEG, PNG ou AVIF)"
    )]
    public ?\Symfony\Component\HttpFoundation\File\File $pathImage;

    // Getter pour $firstname
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    // Setter pour $firstname
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    // Getter pour $lastname
    public function getLastname(): string
    {
        return $this->lastname;
    }

    // Setter pour $lastname
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    // Getter pour $email
    public function getEmail(): string
    {
        return $this->email;
    }

    // Setter pour $email
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    
    // Getter pour $street
    public function getStreet(): string
    {
        return $this->street;
    }

    // Setter pour $street
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    // Getter pour $postcode
    public function getPostcode(): string
    {
        return $this->postcode;
    }

    // Setter pour $postcode
    public function setPostcode(string $postcode): void
    {
        $this->postcode = $postcode;
    }

    // Getter pour $city
    public function getCity(): string
    {
        return $this->city;
    }

    // Setter pour $city
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    // Getter pour $pathImage
    public function getPathImage(): ?\Symfony\Component\HttpFoundation\File\File
    {
        return $this->pathImage;
    }

    // Setter pour $pathImage
    public function setPathImage(?\Symfony\Component\HttpFoundation\File\File  $pathImage): void
    {
        $this->pathImage = $pathImage;
    }
}
