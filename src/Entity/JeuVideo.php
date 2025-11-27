<?php

namespace App\Entity;

use App\Repository\JeuVideoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JeuVideoRepository::class)]
#[ORM\Table(name: 'jeu_video')]
class JeuVideo
{
    #[ORM\Id]
    #[ORM\Column(name: 'ref_jeu', length: 50)]
    private ?string $refJeu = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(name: 'date_parution', type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateParution = null;

    #[ORM\ManyToOne(inversedBy: 'jeux')]
    #[ORM\JoinColumn(name: 'genre_id', referencedColumnName: 'id')]
    private ?Genre $genre = null;

    #[ORM\ManyToOne(inversedBy: 'jeux')]
    #[ORM\JoinColumn(name: 'pegi_id', referencedColumnName: 'id')]
    private ?Pegi $pegi = null;

    #[ORM\ManyToOne(inversedBy: 'jeux')]
    #[ORM\JoinColumn(name: 'plateforme_id', referencedColumnName: 'id')]
    private ?Plateformes $plateforme = null;

    #[ORM\ManyToOne(inversedBy: 'jeux')]
    #[ORM\JoinColumn(name: 'marque_id', referencedColumnName: 'id')]
    private ?Marque $marque = null;

    public function getRefJeu(): ?string
    {
        return $this->refJeu;
    }

    public function setRefJeu(string $refJeu): static
    {
        $this->refJeu = $refJeu;

        return $this;
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDateParution(): ?\DateTimeInterface
    {
        return $this->dateParution;
    }

    public function setDateParution(\DateTimeInterface $dateParution): static
    {
        $this->dateParution = $dateParution;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPegi(): ?Pegi
    {
        return $this->pegi;
    }

    public function setPegi(?Pegi $pegi): static
    {
        $this->pegi = $pegi;

        return $this;
    }

    public function getPlateforme(): ?Plateformes
    {
        return $this->plateforme;
    }

    public function setPlateforme(?Plateformes $plateforme): static
    {
        $this->plateforme = $plateforme;

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): static
    {
        $this->marque = $marque;

        return $this;
    }
}
