<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[Assert\NotBlank(message: "Le nom est requis")]
    #[Assert\Regex(
        pattern: "/^[^\d]+$/",
        message: "Le nom ne doit pas contenir de chiffres"
    )]
    #[Assert\Length(
        max: 20,
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères"
    )] 
    #[ORM\Column(length: 30)]
    private ?string $nom = null;


    #[Assert\NotBlank(message: "Le prenom est requis")]
    #[Assert\Regex(
        pattern: "/^[^\d]+$/",
        message: "Le nom ne doit pas contenir de chiffres"
    )]
    #[Assert\Length(
        max: 20,
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères"
    )]
    #[ORM\Column(length: 30)]
    private ?string $prenom = null;


    #[Assert\Regex(pattern: "/^[0-9]+$/", message: "Le numéro de téléphone ne doit contenir que des chiffres")]
    #[Assert\Length(max: 8, maxMessage: "Le numéro de téléphone doit avoir au maximum 8 chiffres")]
    #[ORM\Column]
    private ?int $telephone = null;


    #[Assert\Regex(
        pattern: "/@/",
        message: "L'adresse e-mail doit contenir le symbole @."
    )]
    #[Assert\NotBlank(message: "L'email est requis")]
    #[ORM\Column(length: 100)]
    private ?string $email = null;


    
 
    #[Assert\Regex(
        pattern: "/^[^\d]+$/",
        message: "Le nom ne doit pas contenir de chiffres"
    )]
    #[Assert\Length(
        max: 20,
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères"
    )]
    #[Assert\NotBlank(message: "L'objet est requis")]
    #[ORM\Column(length: 255)]
    private ?string $objet = null;


    #[Assert\NotBlank(message: "Le message est requis")]
    #[Assert\Regex(
        pattern: "/^[^\d]+$/",
        message: "Le nom ne doit pas contenir de chiffres"
    )]
    #[Assert\Length(
        max: 20,
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères"
    )]
    #[ORM\Column(length: 255)]
    private ?string $message = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): static
    {
        $this->objet = $objet;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }
}
