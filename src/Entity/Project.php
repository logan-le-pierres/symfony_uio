<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
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
     * @ORM\Column(type="string", length=255)
     */
    private $artisticManager;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mailReponsable;

    /**
     * @ORM\ManyToOne(targetEntity=Permission::class, inversedBy="project")
     */
    private $permission;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="project")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=Interfaces::class, inversedBy="projects")
     */
    private $interfaces;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, inversedBy="projects")
     */
    private $role;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->role = new ArrayCollection();
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

    public function getArtisticManager(): ?string
    {
        return $this->artisticManager;
    }

    public function setArtisticManager(string $artisticManager): self
    {
        $this->artisticManager = $artisticManager;

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

    public function getMailReponsable(): ?string
    {
        return $this->mailReponsable;
    }

    public function setMailReponsable(string $mailReponsable): self
    {
        $this->mailReponsable = $mailReponsable;

        return $this;
    }

    public function getPermission(): ?Permission
    {
        return $this->permission;
    }

    public function setPermission(?Permission $permission): self
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addProject($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeProject($this);
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

    /**
     * @return Collection|Role[]
     */
    public function getRole(): Collection
    {
        return $this->role;
    }

    public function addRole(Role $role): self
    {
        if (!$this->role->contains($role)) {
            $this->role[] = $role;
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        $this->role->removeElement($role);

        return $this;
    }
}
