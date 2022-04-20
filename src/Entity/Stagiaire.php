<?php

namespace App\Entity;

use App\Repository\StagiaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StagiaireRepository::class)
 */
class Stagiaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $sexeStagiaire;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nomStagiaire;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenomStagiaire;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telStagiaire;

    /**
     * @ORM\ManyToMany(targetEntity=Session::class, mappedBy="inscriptions")
     */
    private $sessions;
    

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSexeStagiaire(): ?string
    {
        return $this->sexeStagiaire;
    }

    public function setSexeStagiaire(string $sexeStagiaire): self
    {
        $this->sexeStagiaire = $sexeStagiaire;

        return $this;
    }

    public function getNomStagiaire(): ?string
    {
        return $this->nomStagiaire;
    }

    public function setNomStagiaire(string $nomStagiaire): self
    {
        $this->nomStagiaire = $nomStagiaire;

        return $this;
    }

    public function getPrenomStagiaire(): ?string
    {
        return $this->prenomStagiaire;
    }

    public function setPrenomStagiaire(string $prenomStagiaire): self
    {
        $this->prenomStagiaire = $prenomStagiaire;

        return $this;
    }

    public function getTelStagiaire(): ?string
    {
        return $this->telStagiaire;
    }

    public function setTelStagiaire(string $telStagiaire): self
    {
        $this->telStagiaire = $telStagiaire;

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->addInscription($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->removeElement($session)) {
            $session->removeInscription($this);
        }

        return $this;
    }
    
    public function __toString(){
        return $this->prenomStagiaire." ".$this->nomStagiaire;
    }
}
