<?php

namespace App\Entity;

use App\Repository\FormationModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationModuleRepository::class)
 */
class FormationModule
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nomModule;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="formationModules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Planifier::class, mappedBy="moduleFormation")
     */
    private $planifiers;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function __construct()
    {
        $this->planifiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomModule(): ?string
    {
        return $this->nomModule;
    }

    public function setNomModule(string $nomModule): self
    {
        $this->nomModule = $nomModule;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Planifier>
     */
    public function getPlanifiers(): Collection
    {
        return $this->planifiers;
    }

    public function addPlanifier(Planifier $planifier): self
    {
        if (!$this->planifiers->contains($planifier)) {
            $this->planifiers[] = $planifier;
            $planifier->setModuleFormation($this);
        }

        return $this;
    }

    public function removePlanifier(Planifier $planifier): self
    {
        if ($this->planifiers->removeElement($planifier)) {
            // set the owning side to null (unless already changed)
            if ($planifier->getModuleFormation() === $this) {
                $planifier->setModuleFormation(null);
            }
        }

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
    public function __toString(){
    return $this->nomModule;
    }
}
