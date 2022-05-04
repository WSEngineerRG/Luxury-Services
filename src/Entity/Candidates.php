<?php

namespace App\Entity;

use App\Repository\CandidatesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidatesRepository::class)]
class Candidates
{
    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $gender;


    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $firstName;


    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $lastName;


    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $adress;


    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $country;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $nationality;


    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $passport;


    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $cv;


    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $profilPicture;


    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $currentLocation;


    #[ORM\Column(type: "date", nullable: true)]
    private $dateOfBirth;


    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $placeOfBirth;


    #[ORM\Column(type: "boolean", nullable: true)]
    private $availability;


    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $shortDescription;


    #[ORM\ManyToOne(targetEntity: "InfoAdminCandidate", cascade: ["persist", "remove"])]
    #[ORM\JoinColumn(name: "info_admin_candidate_id", referencedColumnName: "id")]
    private $adminInfo;


    #[ORM\OneToOne(targetEntity: "Experience", cascade: ["persist", "remove"])]
    #[ORM\JoinColumn(name: "experience_id", referencedColumnName: "id")]
    private $experience;


    #[ORM\ManyToOne(targetEntity: "JobCategory", cascade: ["persist", "remove"])]
    #[ORM\JoinColumn(name: "job_category_id", referencedColumnName: "id")]
    private $jobCategory;


    #[ORM\OneToOne(targetEntity: "User", cascade: ["persist"])]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private $user;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(?string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getPassport(): ?string
    {
        return $this->passport;
    }

    public function setPassport(?string $passport): self
    {
        $this->passport = $passport;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getProfilPicture(): ?string
    {
        return $this->profilPicture;
    }

    public function setProfilPicture(?string $profilPicture): self
    {
        $this->profilPicture = $profilPicture;

        return $this;
    }

    public function getCurrentLocation(): ?string
    {
        return $this->currentLocation;
    }

    public function setCurrentLocation(?string $currentLocation): self
    {
        $this->currentLocation = $currentLocation;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getPlaceOfBirth(): ?string
    {
        return $this->placeOfBirth;
    }

    public function setPlaceOfBirth(?string $placeOfBirth): self
    {
        $this->placeOfBirth = $placeOfBirth;

        return $this;
    }

    public function getAvailability(): ?bool
    {
        return $this->availability;
    }

    public function setAvailability(?bool $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getAdminInfo(): ? InfoAdminCandidate
    {
        return $this->adminInfo;
    }

    public function setAdminInfo(InfoAdminCandidate $adminInfo): self
    {
        $this->adminInfo = $adminInfo;

        return $this;
    }

    public function getExperience(): ? Experience
    {
        return $this->experience;
    }

    public function setExperience(Experience $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getJobCategory(): ? JobCategory
    {
        return $this->jobCategory;
    }

    public function setJobCategory(JobCategory $jobCategory): self
    {
        $this->jobCategory = $jobCategory;

        return $this;
    }

    public function getUser(): ? User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function __toString()
    {
        return  strval($this->getLastName());
    }
}