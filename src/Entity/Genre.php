<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'lib_genre', length: 255)]
    private ?string $libGenre = null;

    /**
     * @var Collection<int, JeuVideo>
     */
    #[ORM\OneToMany(targetEntity: JeuVideo::class, mappedBy: 'genre')]
    private Collection $jeux;

    public function __construct()
    {
        $this->jeux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibGenre(): ?string
    {
        return $this->libGenre;
    }

    public function setLibGenre(string $libGenre): static
    {
        $this->libGenre = $libGenre;

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
            $jeu->setGenre($this);
        }

        return $this;
    }

    public function removeJeu(JeuVideo $jeu): static
    {
        if ($this->jeux->removeElement($jeu)) {
            if ($jeu->getGenre() === $this) {
                $jeu->setGenre(null);
            }
        }

        return $this;
    }
}
