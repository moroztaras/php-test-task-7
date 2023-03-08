<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ReturnTypeWillChange;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: MobileNumber::class, cascade: ['persist'])]
    private Collection $mobileNumbers;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return Collection|MobileNumber[]
     */
    public function getMobileNumbers(): Collection
    {
        return $this->mobileNumbers;
    }

    public function addMobileNumber(MobileNumber $mobileNumber): self
    {
        if (!$this->mobileNumbers->contains($mobileNumber)) {
            $this->mobileNumbers[] = $mobileNumber;
            $mobileNumber->setUser($this);
        }

        return $this;
    }

    public function removeMobileNumber(MobileNumber $mobileNumber): self
    {
        if ($this->mobileNumbers->contains($mobileNumber)) {
            $this->mobileNumbers->removeElement($mobileNumber);
            // set the owning side to null (unless already changed)
            if ($mobileNumber->getUser() === $this) {
                $mobileNumber->setUser(null);
            }
        }

        return $this;
    }

    #[ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'birthday' => $this->getBirthday()->format('c'),
            'mobile_numbers' => $this->getMobileNumbers()
        ];
    }
}
