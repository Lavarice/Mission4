<?php

namespace App\Entity;

use App\Repository\PegiRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PegiRepository::class)]
class Pegi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private ?int $ageLimite = null;

    #[ORM\Column(length: 255)]
    private ?string $descPegi = null;

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
}
