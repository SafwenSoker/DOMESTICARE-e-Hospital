<?php

namespace App\Entity;

use App\Repository\MeetingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MeetingRepository::class)
 */
class Meeting
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
    private $uuid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $host_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $host_email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $topic;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start_time;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $duration;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="text")
     */
    private $start_url;

    /**
     * @ORM\Column(type="text")
     */
    private $join_url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $h323_password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pstn_password;

    /**
     * @ORM\Column(type="text")
     */
    private $encrypted_password;

    /**
     * @ORM\ManyToOne(targetEntity=Medecin::class, inversedBy="meetings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $medecin;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="meetings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\Column(type="integer")
     */
    private $sndId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getHostId(): ?string
    {
        return $this->host_id;
    }

    public function setHostId(string $host_id): self
    {
        $this->host_id = $host_id;

        return $this;
    }

    public function getHostEmail(): ?string
    {
        return $this->host_email;
    }

    public function setHostEmail(string $host_email): self
    {
        $this->host_email = $host_email;

        return $this;
    }

    public function getTopic(): ?string
    {
        return $this->topic;
    }

    public function setTopic(string $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->start_time;
    }

    public function setStartTime(\DateTimeInterface $start_time): self
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getStartUrl(): ?string
    {
        return $this->start_url;
    }

    public function setStartUrl(string $start_url): self
    {
        $this->start_url = $start_url;

        return $this;
    }

    public function getJoinUrl(): ?string
    {
        return $this->join_url;
    }

    public function setJoinUrl(string $join_url): self
    {
        $this->join_url = $join_url;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getH323Password(): ?string
    {
        return $this->h323_password;
    }

    public function setH323Password(string $h323_password): self
    {
        $this->h323_password = $h323_password;

        return $this;
    }

    public function getPstnPassword(): ?string
    {
        return $this->pstn_password;
    }

    public function setPstnPassword(string $pstn_password): self
    {
        $this->pstn_password = $pstn_password;

        return $this;
    }

    public function getEncryptedPassword(): ?string
    {
        return $this->encrypted_password;
    }

    public function setEncryptedPassword(string $encrypted_password): self
    {
        $this->encrypted_password = $encrypted_password;

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

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getSndId(): ?int
    {
        return $this->sndId;
    }

    public function setSndId(int $sndId): self
    {
        $this->sndId = $sndId;

        return $this;
    }
}
