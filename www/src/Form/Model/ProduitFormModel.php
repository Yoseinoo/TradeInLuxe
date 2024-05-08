<?php

namespace App\Form\Model;

use App\Entity\Categorie;
use Symfony\Component\Validator\Constraints as Assert;

class ProduitFormModel
{
    #[Assert\NotBlank(message:'Le nom est requis.')]
    #[Assert\Length(min:2, max:35, minMessage: 'Le nom doit comporter au moins {{ limit }} caractères.',maxMessage: 'Le nom doit comporter moins de {{ limit }} caractères.')]
    public string $name;
    #[Assert\NotBlank(message:'La catégorie est requise.')]
    public Categorie $categorie;
    #[Assert\NotBlank(message:'La description est requise.')]
    #[Assert\Length(min:5, max:1000, minMessage: 'La description doit comporter au moins {{ limit }} caractères.',maxMessage: 'La description doit comporter moins de {{ limit }} caractères.')]
    public string $description;
    #[Assert\NotBlank(message:'La marque est requise.')]
    #[Assert\Length(min:2, max:35, minMessage: 'La marque doit comporter au moins {{ limit }} caractères.',maxMessage: 'La marque doit comporter moins de {{ limit }} caractères.')]
    public $marque;
    #[Assert\NotBlank(message:'La taille est requise.')]
    #[Assert\Length(min:1, max:5, minMessage: 'La taille doit comporter au moins {{ limit }} caractères.',maxMessage: 'La taille doit comporter moins de {{ limit }} caractères.')]
    public $taille;
    #[Assert\NotBlank(message:'La couleur est requise.')]
    #[Assert\Length(min:1, max:10, minMessage: 'La couleur doit comporter au moins {{ limit }} caractères.',maxMessage: 'La couleur doit comporter moins de {{ limit }} caractères.')]
    public $couleur;
    #[Assert\NotBlank(message:'Le genre est requis.')]
    public $genre;
    #[Assert\NotBlank(message:'Les photos sont requises.')]
    public $photos;


     // Getter et Setter pour "name"
     public function getName(): string
     {
         return $this->name;
     }
 
     public function setName(string $name): void
     {
         $this->name = $name;
     }
 
     // Getter et Setter pour "categorie"
     public function getCategorie(): Categorie
     {
         return $this->categorie;
     }
 
     public function setCategorie(Categorie $categorie): void
     {
         $this->categorie = $categorie;
     }
 
     // Getter et Setter pour "description"
     public function getDescription(): string
     {
         return $this->description;
     }
 
     public function setDescription(string $description): void
     {
         $this->description = $description;
     }
 
     // Getter et Setter pour "marque"
     public function getMarque()
     {
         return $this->marque;
     }
 
     public function setMarque($marque): void
     {
         $this->marque = $marque;
     }
 
     // Getter et Setter pour "taille"
     public function getTaille()
     {
         return $this->taille;
     }
 
     public function setTaille($taille): void
     {
         $this->taille = $taille;
     }
 
     // Getter et Setter pour "couleur"
     public function getCouleur()
     {
         return $this->couleur;
     }
 
     public function setCouleur($couleur): void
     {
         $this->couleur = $couleur;
     }
 
     // Getter et Setter pour "genre"
     public function getGenre()
     {
         return $this->genre;
     }
 
     public function setGenre($genre): void
     {
         $this->genre = $genre;
     }  
}
