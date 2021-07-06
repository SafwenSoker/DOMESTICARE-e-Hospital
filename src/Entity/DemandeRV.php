<?php

namespace App\Entity;

use App\Repository\DemandeRVRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DemandeRVRepository::class)
 */
class DemandeRV
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="demandeRVs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity=Medecin::class, inversedBy="demandeRVs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $medecin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?Medecin $medecin): self
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function __toString()
    {
        $format = "DemandeRV (id: %s, patient: %s, medecin: %s)";
        return sprintf($format, $this->id, $this->patient, $this->medecin);
    }
}
