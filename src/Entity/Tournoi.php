<?php

namespace App\Entity;

use App\Repository\TournoiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TournoiRepository::class)]
class Tournoi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $nbParticipants = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Plateformes::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Plateformes $plateforme = null;

    #[ORM\ManyToOne(inversedBy: 'tournois')]
    #[ORM\JoinColumn(nullable: true)]
    private ?CatTournoi $catTournoi = null;

    /**
     * @var Collection<int, Participant>
     */
    #[ORM\ManyToMany(targetEntity: Participant::class, inversedBy: 'tournois')]
    private Collection $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getNbParticipants(): ?int
    {
        return $this->nbParticipants;
    }

    public function setNbParticipants(?int $nbParticipants): static
    {
        $this->nbParticipants = $nbParticipants;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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

    public function getCatTournoi(): ?CatTournoi
    {
        return $this->catTournoi;
    }

    public function setCatTournoi(?CatTournoi $catTournoi): static
    {
        $this->catTournoi = $catTournoi;

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): static
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): static
    {
        $this->participants->removeElement($participant);

        return $this;
    }
}
