<?php

namespace App\Entity;

use App\Repository\MarqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarqueRepository::class)]
class Marque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'nom_marque', length: 255)]
    private ?string $nomMarque = null;

    /**
     * @var Collection<int, JeuVideo>
     */
    #[ORM\OneToMany(targetEntity: JeuVideo::class, mappedBy: 'marque')]
    private Collection $jeux;

    public function __construct()
    {
        $this->jeux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMarque(): ?string
    {
        return $this->nomMarque;
    }

    public function setNomMarque(string $nomMarque): static
    {
        $this->nomMarque = $nomMarque;

        return $this;
    }

    /**
     * @return Collection<int, JeuVideo>
     */
    public function getJeux(): Collection
    {
        return $this->jeux;
    }

    public function addJeu(JeuVideo $jeu): static
    {
        if (!$this->jeux->contains($jeu)) {
            $this->jeux->add($jeu);
            $jeu->setMarque($this);
        }

        return $this;
    }

    public function removeJeu(JeuVideo $jeu): static
    {
        if ($this->jeux->removeElement($jeu)) {
            if ($jeu->getMarque() === $this) {
                $jeu->setMarque(null);
            }
        }

        return $this;
    }
}
