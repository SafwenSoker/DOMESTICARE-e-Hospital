<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient
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
     * @ORM\Column(type="integer")
     */
    private $numero_telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\Column(type="integer")
     */
    private $cin;

    /**
     * @ORM\Column(type="text")
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity=DemandeRV::class, mappedBy="patient")
     */
    private $demandeRVs;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="patient")
     */
    private $commentaires;

    /**
     * @ORM\OneToOne(targetEntity=ComptePatient::class, mappedBy="patient", cascade={"persist", "remove"})
     */
    private $comptePatient;
    public $confirm_cin;

    /**
     * @ORM\OneToMany(targetEntity=Messages::class, mappedBy="sender", orphanRemoval=true)
     */
    private $sent;

    /**
     * @ORM\OneToMany(targetEntity=Messages::class, mappedBy="recipient", orphanRemoval=true)
     */
    private $recieved;

    /**
     * @ORM\OneToMany(targetEntity=Meeting::class, mappedBy="patient", orphanRemoval=true)
     */
    private $meetings;

    public function __construct()
    {
        $this->demandeRVs = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->sent = new ArrayCollection();
        $this->recieved = new ArrayCollection();
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

    public function getNumeroTelephone(): ?int
    {
        return $this->numero_telephone;
    }

    public function setNumeroTelephone(int $numero_telephone): self
    {
        $this->numero_telephone = $numero_telephone;

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

    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(int $cin): self
    {
        $this->cin = $cin;

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
            $demandeRV->setPatient($this);
        }

        return $this;
    }

    public function removeDemandeRV(DemandeRV $demandeRV): self
    {
        if ($this->demandeRVs->removeElement($demandeRV)) {
            // set the owning side to null (unless already changed)
            if ($demandeRV->getPatient() === $this) {
                $demandeRV->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setPatient($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getPatient() === $this) {
                $commentaire->setPatient(null);
            }
        }

        return $this;
    }

    public function getComptePatient(): ?ComptePatient
    {
        return $this->comptePatient;
    }

    public function setComptePatient(ComptePatient $comptePatient): self
    {
        // set the owning side of the relation if necessary
        if ($comptePatient->getPatient() !== $this) {
            $comptePatient->setPatient($this);
        }

        $this->comptePatient = $comptePatient;

        return $this;
    }

    public function __toString()
    {
        $format = 'Patient :  %s %s | adresse: %s | numéro téléphone: %s ';

        return sprintf($format, $this->nom, $this->prenom, $this->adresse, $this->numero_telephone);
    }

    /**
     * @return Collection|Messages[]
     */
    public function getSent(): Collection
    {
        return $this->sent;
    }

    public function addSent(Messages $sent): self
    {
        if (!$this->sent->contains($sent)) {
            $this->sent[] = $sent;
            $sent->setSender($this);
        }

        return $this;
    }

    public function removeSent(Messages $sent): self
    {
        if ($this->sent->removeElement($sent)) {
            // set the owning side to null (unless already changed)
            if ($sent->getSender() === $this) {
                $sent->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Messages[]
     */
    public function getRecieved(): Collection
    {
        return $this->recieved = !empty($this->recieved) ? $this->recieved : [];
    }

    public function addRecieved(Messages $recieved): self
    {
        if (!$this->recieved->contains($recieved)) {
            $this->recieved[] = $recieved;
            $recieved->setRecipient($this);
        }

        return $this;
    }

    public function removeRecieved(Messages $recieved): self
    {
        if ($this->recieved->removeElement($recieved)) {
            // set the owning side to null (unless already changed)
            if ($recieved->getRecipient() === $this) {
                $recieved->setRecipient(null);
            }
        }

        return $this;
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
            $meeting->setPatient($this);
        }

        return $this;
    }

    public function removeMeeting(Meeting $meeting): self
    {
        if ($this->meetings->removeElement($meeting)) {
            // set the owning side to null (unless already changed)
            if ($meeting->getPatient() === $this) {
                $meeting->setPatient(null);
            }
        }

        return $this;
    }
}
