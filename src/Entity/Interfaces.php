<?php

namespace App\Entity;

use App\Repository\InterfacesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InterfacesRepository::class)
 */
class Interfaces
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
    private $numSequence;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numEpisode;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateModifcation;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $reason;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="interfaces")
     */
    private $projects;

    /**
     * @ORM\OneToMany(targetEntity=Bundle::class, mappedBy="interfaces")
     */
    private $bundles;

    /**
     * @ORM\ManyToOne(targetEntity=Validation::class, inversedBy="interfaces")
     */
    private $validation;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->bundles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumSequence(): ?string
    {
        return $this->numSequence;
    }

    public function setNumSequence(string $numSequence): self
    {
        $this->numSequence = $numSequence;

        return $this;
    }

    public function getNumEpisode(): ?string
    {
        return $this->numEpisode;
    }

    public function setNumEpisode(string $numEpisode): self
    {
        $this->numEpisode = $numEpisode;

        return $this;
    }

    public function getDateModifcation(): ?\DateTimeInterface
    {
        return $this->dateModifcation;
    }

    public function setDateModifcation(\DateTimeInterface $dateModifcation): self
    {
        $this->dateModifcation = $dateModifcation;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): self
    {
        $this->reason = $reason;

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
            $project->setInterfaces($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getInterfaces() === $this) {
                $project->setInterfaces(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Bundle[]
     */
    public function getBundles(): Collection
    {
        return $this->bundles;
    }

    public function addBundle(Bundle $bundle): self
    {
        if (!$this->bundles->contains($bundle)) {
            $this->bundles[] = $bundle;
            $bundle->setInterfaces($this);
        }

        return $this;
    }

    public function removeBundle(Bundle $bundle): self
    {
        if ($this->bundles->removeElement($bundle)) {
            // set the owning side to null (unless already changed)
            if ($bundle->getInterfaces() === $this) {
                $bundle->setInterfaces(null);
            }
        }

        return $this;
    }

    public function getValidation(): ?Validation
    {
        return $this->validation;
    }

    public function setValidation(?Validation $validation): self
    {
        $this->validation = $validation;

        return $this;
    }
}
