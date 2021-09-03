<?php

namespace App\Entity;

use App\Repository\ValidationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ValidationRepository::class)
 */
class Validation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $decision;

    /**
     * @ORM\Column(type="datetime")
     */
    private $validationDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reason;

    /**
     * @ORM\OneToMany(targetEntity=Interfaces::class, mappedBy="validation")
     */
    private $interfaces;

    public function __construct()
    {
        $this->interfaces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDecision(): ?string
    {
        return $this->decision;
    }

    public function setDecision(string $decision): self
    {
        $this->decision = $decision;

        return $this;
    }

    public function getValidationDate(): ?\DateTimeInterface
    {
        return $this->validationDate;
    }

    public function setValidationDate(\DateTimeInterface $validationDate): self
    {
        $this->validationDate = $validationDate;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * @return Collection|Interfaces[]
     */
    public function getInterfaces(): Collection
    {
        return $this->interfaces;
    }

    public function addInterface(Interfaces $interface): self
    {
        if (!$this->interfaces->contains($interface)) {
            $this->interfaces[] = $interface;
            $interface->setValidation($this);
        }

        return $this;
    }

    public function removeInterface(Interfaces $interface): self
    {
        if ($this->interfaces->removeElement($interface)) {
            // set the owning side to null (unless already changed)
            if ($interface->getValidation() === $this) {
                $interface->setValidation(null);
            }
        }

        return $this;
    }
}
