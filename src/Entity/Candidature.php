<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
class Candidature
{
    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\ManyToOne(targetEntity: Candidates::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "candidate_id", referencedColumnName: "id")]
    private $candidates;

    #[ORM\ManyToOne(targetEntity: JobOffer::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "job_offer_id", referencedColumnName: "id")]
    private $jobOffer;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getJobOffer(): ?JobOffer
    {
        return $this->jobOffer;
    }

    public function setJobOffer(?JobOffer $jobOffer): self
    {
        $this->jobOffer = $jobOffer;

        return $this;
    }
    public function getCandidates(): ?Candidates
    {
        return $this->candidates;
    }

    public function setCandidates(?Candidates $candidates): self
    {
        $this->candidates = $candidates;

        return $this;
    }
}