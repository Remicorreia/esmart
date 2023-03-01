<?php

namespace App\Entity;

use App\Repository\CapaciteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CapaciteRepository::class)]
class Capacite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $valeur = null;

    #[ORM\Column(length: 10)]
    private ?string $unite = null;

    #[ORM\ManyToOne(inversedBy: 'capacite')]
    private ?Smartphone $smartphone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeur(): ?int
    {
        return $this->valeur;
    }

    public function setValeur(int $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(string $unite): self
    {
        $this->unite = $unite;

        return $this;
    }

    public function getSmartphone(): ?Smartphone
    {
        return $this->smartphone;
    }

    public function setSmartphone(?Smartphone $smartphone): self
    {
        $this->smartphone = $smartphone;

        return $this;
    }
}
