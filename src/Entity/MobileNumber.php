<?php

namespace App\Entity;

use App\Repository\MobileNumberRepository;
use Doctrine\ORM\Mapping as ORM;
use ReturnTypeWillChange;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MobileNumberRepository::class)]
class MobileNumber implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameOperator = null;

    #[ORM\Column(length: 3)]
    #[Assert\Range(min:100, max:999)]
    private ?int $codeCountry = null;

    #[ORM\Column(length: 2)]
    #[Assert\Range(min:50, max:99)]
    private ?int $codeOperator = null;

    #[ORM\Column(length: 7)]
    #[Assert\Range(min:1000000, max:9999999)]
    private ?int $number = null;

    #[ORM\Column]
    #[Assert\Range(min:-150, max:150)]
    private ?float $balance = 0.0;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'mobileNumbers')]
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

    /**
     * Get user.
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Set user.
     *
     * @param User|null $user
     *
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    #[ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'name_operator' => $this->getNameOperator(),
            'code_country' => $this->getCodeCountry(),
            'code_operator' => $this->getCodeOperator(),
            'number' => $this->getNumber(),
            'balance' => $this->getBalance(),
        ];
    }
}
