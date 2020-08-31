<?php

namespace App\Entity;

use App\Repository\ConfigRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConfigRepository::class)
 */
class Config
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ethName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEthName(): ?string
    {
        return $this->ethName;
    }

    public function setEthName(string $ethName): self
    {
        $this->ethName = $ethName;

        return $this;
    }
}
