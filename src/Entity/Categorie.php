<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
    private $nomCategorie;

    /**
     * @ORM\OneToMany(targetEntity=FormationModule::class, mappedBy="categorie")
     */
    private $formationModules;

    public function __construct()
    {
        $this->formationModules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(string $nomCategorie): self
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    /**
     * @return Collection<int, FormationModule>
     */
    public function getFormationModules(): Collection
    {
        return $this->formationModules;
    }

    public function addFormationModule(FormationModule $formationModule): self
    {
        if (!$this->formationModules->contains($formationModule)) {
            $this->formationModules[] = $formationModule;
            $formationModule->setCategorie($this);
        }

        return $this;
    }

    public function removeFormationModule(FormationModule $formationModule): self
    {
        if ($this->formationModules->removeElement($formationModule)) {
            // set the owning side to null (unless already changed)
            if ($formationModule->getCategorie() === $this) {
                $formationModule->setCategorie(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->nomCategorie;
    }
}
