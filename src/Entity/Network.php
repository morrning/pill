<?php

namespace App\Entity;

use App\Repository\NetworkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=NetworkRepository::class)
 */
class Network
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Ip
     * @ORM\Column(type="string", length=15)
     */
    private $address;

    /**
     * @Assert\Ip
     * @ORM\Column(type="string", length=15)
     */
    private $network;

    /**
     * @Assert\Ip
     * @ORM\Column(type="string", length=15)
     */
    private $gateway;

    /**
     * @Assert\Ip
     * @ORM\Column(type="string", length=15)
     */
    private $dns1;

    /**
     * @Assert\Ip
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $dns2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getNetwork(): ?string
    {
        return $this->network;
    }

    public function setNetwork(string $network): self
    {
        $this->network = $network;

        return $this;
    }

    public function getGateway(): ?string
    {
        return $this->gateway;
    }

    public function setGateway(string $gateway): self
    {
        $this->gateway = $gateway;

        return $this;
    }

    public function getDns1(): ?string
    {
        return $this->dns1;
    }

    public function setDns1(string $dns1): self
    {
        $this->dns1 = $dns1;

        return $this;
    }

    public function getDns2(): ?string
    {
        return $this->dns2;
    }

    public function setDns2(?string $dns2): self
    {
        $this->dns2 = $dns2;

        return $this;
    }
}
