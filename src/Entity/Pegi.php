<?php

namespace App\Entity;

use App\Repository\PegiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PegiRepository::class)]
class Pegi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'age_limite', type: 'integer')]
    private ?int $ageLimite = null;

    #[ORM\Column(name: 'desc_pegi', length: 255)]
    private ?string $descPegi = null;

    /**
     * @var Collection<int, JeuVideo>
     */
    #[ORM\OneToMany(targetEntity: JeuVideo::class, mappedBy: 'pegi')]
    private Collection $jeux;

    public function __construct()
    {
        $this->jeux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgeLimite(): ?int
    {
        return $this->ageLimite;
    }

    public function setAgeLimite(int $ageLimite): static
    {
        $this->ageLimite = $ageLimite;

        return $this;
    }

    public function getDescPegi(): ?string
    {
        return $this->descPegi;
    }

    public function setDescPegi(string $descPegi): static
    {
        $this->descPegi = $descPegi;

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
            $jeu->setPegi($this);
        }

        return $this;
    }

    public function removeJeu(JeuVideo $jeu): static
    {
        if ($this->jeux->removeElement($jeu)) {
            if ($jeu->getPegi() === $this) {
                $jeu->setPegi(null);
            }
        }

        return $this;
    }
}
