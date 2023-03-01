<?php

namespace App\Entity;

use App\Repository\YfguhRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: YfguhRepository::class)]
class Yfguh
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
