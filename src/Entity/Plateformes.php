<?php

namespace App\Entity;

use App\Repository\PlateformesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlateformesRepository::class)]
class Plateformes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'lib_plateforme', length: 255)]
    private ?string $libPlateforme = null;

    /**
     * @var Collection<int, JeuVideo>
     */
    #[ORM\OneToMany(targetEntity: JeuVideo::class, mappedBy: 'plateforme')]
    private Collection $jeux;

    public function __construct()
    {
        $this->jeux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibPlateforme(): ?string
    {
        return $this->libPlateforme;
    }

    public function setLibPlateforme(string $libPlateforme): static
    {
        $this->libPlateforme = $libPlateforme;

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
            $jeu->setPlateforme($this);
        }

        return $this;
    }

    public function removeJeu(JeuVideo $jeu): static
    {
        if ($this->jeux->removeElement($jeu)) {
            if ($jeu->getPlateforme() === $this) {
                $jeu->setPlateforme(null);
            }
        }

        return $this;
    }
}
