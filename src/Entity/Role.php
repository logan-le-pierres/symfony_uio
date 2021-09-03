<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
class Role
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
    private $firstName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $aliveOrNot;

    /**
     * @ORM\Column(type="date")
     */
    private $birth;

    /**
     * @ORM\Column(type="date")
     */
    private $death;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Project::class, mappedBy="role")
     */
    private $projects;

    /**
     * @ORM\ManyToOne(targetEntity=File::class, inversedBy="roles")
     */
    private $files;

    /**
     * @ORM\ManyToMany(targetEntity=UApp::class, inversedBy="roles")
     */
    private $uapp;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->uapp = new ArrayCollection();
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getAliveOrNot(): ?bool
    {
        return $this->aliveOrNot;
    }

    public function setAliveOrNot(bool $aliveOrNot): self
    {
        $this->aliveOrNot = $aliveOrNot;

        return $this;
    }

    public function getBirth(): ?\DateTimeInterface
    {
        return $this->birth;
    }

    public function setBirth(\DateTimeInterface $birth): self
    {
        $this->birth = $birth;

        return $this;
    }

    public function getDeath(): ?\DateTimeInterface
    {
        return $this->death;
    }

    public function setDeath(\DateTimeInterface $death): self
    {
        $this->death = $death;

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

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->addRole($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            $project->removeRole($this);
        }

        return $this;
    }

    public function getFiles(): ?File
    {
        return $this->files;
    }

    public function setFiles(?File $files): self
    {
        $this->files = $files;

        return $this;
    }

    /**
     * @return Collection|UApp[]
     */
    public function getUapp(): Collection
    {
        return $this->uapp;
    }

    public function addUapp(UApp $uapp): self
    {
        if (!$this->uapp->contains($uapp)) {
            $this->uapp[] = $uapp;
        }

        return $this;
    }

    public function removeUapp(UApp $uapp): self
    {
        $this->uapp->removeElement($uapp);

        return $this;
    }
}
