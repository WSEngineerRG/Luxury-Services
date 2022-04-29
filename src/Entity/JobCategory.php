<?php

namespace App\Entity;

use App\Repository\JobCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobCategoryRepository::class)]
class JobCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: JobOffer::class)]
    private $offers;

    #[ORM\OneToMany(mappedBy: 'jobCategory', targetEntity: Profile::class)]
    private $profiles;

    public function __construct()
    {
        $this->jobOffers = new ArrayCollection();
        $this->profiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, JobOffer>
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(JobOffer $jobOffer): self
    {
        if (!$this->offers->contains($jobOffer)) {
            $this->offers[] = $jobOffer;
            $jobOffer->setCategory($this);
        }

        return $this;
    }

    public function removeOffer(JobOffer $jobOffer): self
    {
        if ($this->offers->removeElement($jobOffer)) {
            // set the owning side to null (unless already changed)
            if ($jobOffer->getCategory() === $this) {
                $jobOffer->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Profile>
     */
    public function getProfiles(): Collection
    {
        return $this->profiles;
    }

    public function addProfile(Profile $profile): self
    {
        if (!$this->profiles->contains($profile)) {
            $this->profiles[] = $profile;
            $profile->setJobCategory($this);
        }

        return $this;
    }

    public function removeProfile(Profile $profile): self
    {
        if ($this->profiles->removeElement($profile)) {
            // set the owning side to null (unless already changed)
            if ($profile->getJobCategory() === $this) {
                $profile->setJobCategory(null);
            }
        }

        return $this;
    }
}
