<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
        max: 30,
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères"
    )]
    #[ORM\Column(length: 30)]
    private ?string $prenom = null;


    #[Assert\Regex(pattern: "/^\d{8}$/", message: "Le numéro de téléphone doit contenir exactement 8 chiffres")]
    #[ORM\Column]
    private ?int $telephone = null;


    #[Assert\Email(message: "L'adresse e-mail '{{ value }}' n'est pas valide.")]
    #[Assert\NotBlank(message: "L'email est requis")]
    #[ORM\Column(length: 100)]
    private ?string $email = null;


    
 
    #[Assert\Regex(
        pattern: "/^[^\d]+$/",
        message: "L'objet ne doit pas contenir de chiffres"
    )]
    #[Assert\Length(
        max: 20,
        maxMessage: "L'objet ne peut pas dépasser {{ limit }} caractères"
    )]
    #[Assert\NotBlank(message: "L'objet est requis")]
    #[ORM\Column(length: 255)]
    private ?string $objet = null;


    #[Assert\NotBlank(message: "Le message est requis")]
    #[Assert\Length(
        max: 20,
        maxMessage: "Le message ne peut pas dépasser {{ limit }} caractères"
    )]
    #[ORM\Column(length: 255)]
    private ?string $message = null;

    #[ORM\OneToMany(mappedBy: 'reclamation', targetEntity: Reponse::class)]
    private Collection $reclamation_r;

    #[ORM\Column(length: 50)]
    private ?string $etat ="en cours de traitement";

    public function nouveauConstructeur()
    {
        // Initialisez la propriété à "en cours de traitement" uniquement si elle est nulle
        $this->etat = $this->etat ?? "en cours de traitement";
    }

    public function __construct()
    {
        $this->reclamation_r = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, reponse>
     */
    public function getReclamationR(): Collection
    {
        return $this->reclamation_r;
    }

    public function addReclamationR(reponse $reclamationR): static
    {
        if (!$this->reclamation_r->contains($reclamationR)) {
            $this->reclamation_r->add($reclamationR);
            $reclamationR->setReclamation($this);
        }

        return $this;
    }

    public function removeReclamationR(reponse $reclamationR): static
    {
        if ($this->reclamation_r->removeElement($reclamationR)) {
            // set the owning side to null (unless already changed)
            if ($reclamationR->getReclamation() === $this) {
                $reclamationR->setReclamation(null);
            }
        }

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }
}
