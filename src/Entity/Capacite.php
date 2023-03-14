<?php

namespace App\Entity;

use App\Repository\CapaciteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CapaciteRepository::class)]
class Capacite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $valeur = null;

    #[ORM\OneToMany(mappedBy: 'capacite', targetEntity: Smartphone::class)]
    private Collection $smartphones;


    /**
     * Convertir l'objet en chaîne de caractères.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->valeur;
    }

    public function __construct()
    {
        $this->smartphones = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * @return Collection<int, Smartphone>
     */
    public function getSmartphones(): Collection
    {
        return $this->smartphones;
    }

    public function addSmartphone(Smartphone $smartphone): self
    {
        if (!$this->smartphones->contains($smartphone)) {
            $this->smartphones->add($smartphone);
            $smartphone->setCapacite($this);
        }

        return $this;
    }

    public function removeSmartphone(Smartphone $smartphone): self
    {
        if ($this->smartphones->removeElement($smartphone)) {
            // set the owning side to null (unless already changed)
            if ($smartphone->getCapacite() === $this) {
                $smartphone->setCapacite(null);
            }
        }

        return $this;
    }

}
