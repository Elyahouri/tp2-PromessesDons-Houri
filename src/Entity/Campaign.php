<?php

namespace App\Entity;

use App\Repository\CampaignRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampaignRepository::class)]
class Campaign
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'campaign', targetEntity: Donation::class)]
    private Collection $donation;

    public function __construct()
    {
        $this->donation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Donation>
     */
    public function getDonation(): Collection
    {
        return $this->donation;
    }

    public function addDonation(Donation $donation): self
    {
        if (!$this->donation->contains($donation)) {
            $this->donation->add($donation);
            $donation->setCampaign($this);
        }

        return $this;
    }

    public function removeDonation(Donation $donation): self
    {
        if ($this->donation->removeElement($donation)) {
            // set the owning side to null (unless already changed)
            if ($donation->getCampaign() === $this) {
                $donation->setCampaign(null);
            }
        }

        return $this;
    }
}
