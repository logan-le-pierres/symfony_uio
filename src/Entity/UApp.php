<?php

namespace App\Entity;

use App\Repository\UAppRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UAppRepository::class)
 */
class UApp
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
     * @ORM\ManyToMany(targetEntity=Role::class, mappedBy="uapp")
     */
    private $roles;

    /**
     * @ORM\ManyToMany(targetEntity=Bundle::class, inversedBy="uApps")
     */
    private $bundle;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->bundle = new ArrayCollection();
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
     * @return Collection|Role[]
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
            $role->addUapp($this);
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->roles->removeElement($role)) {
            $role->removeUapp($this);
        }

        return $this;
    }

    /**
     * @return Collection|Bundle[]
     */
    public function getBundle(): Collection
    {
        return $this->bundle;
    }

    public function addBundle(Bundle $bundle): self
    {
        if (!$this->bundle->contains($bundle)) {
            $this->bundle[] = $bundle;
        }

        return $this;
    }

    public function removeBundle(Bundle $bundle): self
    {
        $this->bundle->removeElement($bundle);

        return $this;
    }
}
