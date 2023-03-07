<?php

namespace App\Entity;

use App\Repository\MobilePhoneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MobilePhoneRepository::class)]
class MobilePhone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameOperator = null;

    #[ORM\Column(length: 3)]
    private ?string $codeCountry = null;

    #[ORM\Column(length: 2)]
    private ?string $codeOperator = null;

    #[ORM\Column(length: 7)]
    private ?string $number = null;

    #[ORM\Column]
    private ?float $balance = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'mobilePhones')]
    private ?User $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameOperator(): ?string
    {
        return $this->nameOperator;
    }

    public function setNameOperator(string $nameOperator): self
    {
        $this->nameOperator = $nameOperator;

        return $this;
    }

    public function getCodeCountry(): ?string
    {
        return $this->codeCountry;
    }

    public function setCodeCountry(string $codeCountry): self
    {
        $this->codeCountry = $codeCountry;

        return $this;
    }

    public function getCodeOperator(): ?string
    {
        return $this->codeOperator;
    }

    public function setCodeOperator(string $codeOperator): self
    {
        $this->codeOperator = $codeOperator;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
