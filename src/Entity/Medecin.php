<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MedecinRepository::class)
 */
class Medecin
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $date_embauche;

    /**
     * @ORM\Column(type="integer")
     */
    private $numero_telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $matricule;

    /**
     * @ORM\Column(type="text")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity=DemandeRV::class, mappedBy="medecin")
     */
    private $demandeRVs;

    /**
     * @ORM\OneToOne(targetEntity=CompteMedecin::class, mappedBy="medecin", cascade={"persist", "remove"})
     */
    private $compteMedecin;

    /**
     * @ORM\OneToMany(targetEntity=Meeting::class, mappedBy="medecin", orphanRemoval=true)
     */
    private $meetings;

    public function __construct()
    {
        $this->demandeRVs = new ArrayCollection();
        $this->meetings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateEmbauche(): ?\DateTimeInterface
    {
        return $this->date_embauche;
    }

    public function setDateEmbauche(\DateTimeInterface $date_embauche): self
    {
        $this->date_embauche = $date_embauche;

        return $this;
    }

    public function getNumeroTelephone(): ?int
    {
        return $this->numero_telephone;
    }

    public function setNumeroTelephone(int $numero_telephone): self
    {
        $this->numero_telephone = $numero_telephone;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection|DemandeRV[]
     */
    public function getDemandeRVs(): Collection
    {
        return $this->demandeRVs;
    }

    public function addDemandeRV(DemandeRV $demandeRV): self
    {
        if (!$this->demandeRVs->contains($demandeRV)) {
            $this->demandeRVs[] = $demandeRV;
            $demandeRV->setMedecin($this);
        }

        return $this;
    }

    public function removeDemandeRV(DemandeRV $demandeRV): self
    {
        if ($this->demandeRVs->removeElement($demandeRV)) {
            // set the owning side to null (unless already changed)
            if ($demandeRV->getMedecin() === $this) {
                $demandeRV->setMedecin(null);
            }
        }

        return $this;
    }

    public function getCompteMedecin(): ?CompteMedecin
    {
        return $this->compteMedecin;
    }

    public function setCompteMedecin(CompteMedecin $compteMedecin): self
    {
        // set the owning side of the relation if necessary
        if ($compteMedecin->getMedecin() !== $this) {
            $compteMedecin->setMedecin($this);
        }

        $this->compteMedecin = $compteMedecin;

        return $this;
    }

    public function __toString()
    {
        $format = 'Patient (id: %s, nom: %s, prenom: %s)';

        return sprintf($format, $this->id, $this->nom, $this->prenom);
    }

    /**
     * @return Collection|Meeting[]
     */
    public function getMeetings(): Collection
    {
        return $this->meetings;
    }

    public function addMeeting(Meeting $meeting): self
    {
        if (!$this->meetings->contains($meeting)) {
            $this->meetings[] = $meeting;
            $meeting->setMedecin($this);
        }

        return $this;
    }

    public function removeMeeting(Meeting $meeting): self
    {
        if ($this->meetings->removeElement($meeting)) {
            // set the owning side to null (unless already changed)
            if ($meeting->getMedecin() === $this) {
                $meeting->setMedecin(null);
            }
        }

        return $this;
    }
}
