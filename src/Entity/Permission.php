<?php

namespace App\Entity;

use App\Repository\PermissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PermissionRepository::class)
 */
class Permission
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
    private $parametre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sectionUio;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="permission")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="permission")
     */
    private $project;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->project = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParametre(): ?string
    {
        return $this->parametre;
    }

    public function setParametre(string $parametre): self
    {
        $this->parametre = $parametre;

        return $this;
    }

    public function getSectionUio(): ?string
    {
        return $this->sectionUio;
    }

    public function setSectionUio(string $sectionUio): self
    {
        $this->sectionUio = $sectionUio;

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
            $user->addPermission($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removePermission($this);
        }

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProject(): Collection
    {
        return $this->project;
    }

    public function addProject(Project $project): self
    {
        if (!$this->project->contains($project)) {
            $this->project[] = $project;
            $project->setPermission($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->project->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getPermission() === $this) {
                $project->setPermission(null);
            }
        }

        return $this;
    }
}
