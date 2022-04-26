<?php

namespace App\Entity;

use App\Repository\PlanifierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlanifierRepository::class)
 */
class Planifier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $duree;

    /**
     * @ORM\ManyToOne(targetEntity=FormationModule::class, inversedBy="planifiers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $moduleFormation;

    /**
     * @ORM\ManyToOne(targetEntity=Session::class, inversedBy="planifiers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sessionDuree;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuree(): ?float
    {
        return $this->duree;
    }

    public function setDuree(float $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getModuleFormation(): ?FormationModule
    {
        return $this->moduleFormation;
    }

    public function setModuleFormation(?FormationModule $moduleFormation): self
    {
        $this->moduleFormation = $moduleFormation;

        return $this;
    }

    public function getSessionDuree(): ?Session
    {
        return $this->sessionDuree;
    }

    public function setSessionDuree(?Session $sessionDuree): self
    {
        $this->sessionDuree = $sessionDuree;

        return $this;
    }
}
