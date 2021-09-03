<?php

namespace App\Entity;

use App\Repository\BundleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BundleRepository::class)
 */
class Bundle
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
    private $name;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity=UApp::class, mappedBy="bundle")
     */
    private $uApps;

    /**
     * @ORM\ManyToOne(targetEntity=Interfaces::class, inversedBy="bundles")
     */
    private $interfaces;

    public function __construct()
    {
        $this->uApps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

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

    /**
     * @return Collection|UApp[]
     */
    public function getUApps(): Collection
    {
        return $this->uApps;
    }

    public function addUApp(UApp $uApp): self
    {
        if (!$this->uApps->contains($uApp)) {
            $this->uApps[] = $uApp;
            $uApp->addBundle($this);
        }

        return $this;
    }

    public function removeUApp(UApp $uApp): self
    {
        if ($this->uApps->removeElement($uApp)) {
            $uApp->removeBundle($this);
        }

        return $this;
    }

    public function getInterfaces(): ?Interfaces
    {
        return $this->interfaces;
    }

    public function setInterfaces(?Interfaces $interfaces): self
    {
        $this->interfaces = $interfaces;

        return $this;
    }
}
