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

    private ?int $sommeDonation;

    #[ORM\Column(nullable: true)]
    private ?bool $activated = null;

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

    public function isActivated(): ?bool
    {
        return $this->activated;
    }

    public function setActivated(?bool $activated): self
    {
        $this->activated = $activated;

        return $this;
    }

    public function getNbDonations()
    {
        $nbDon = 0;

        foreach ($this->getDonation() as $don){
            $nbDon+=1;

        }
        return $nbDon;
    }

    public function getSommeDonation(): ?int
    {
        $sum = 0;
        foreach ($this->getDonation() as $don){
            $sum+=$don->getAmount();
        }
        $this->sommeDonation = $sum;
        return $this->sommeDonation;
    }

    public function getSommeDonationHonored(): ?int
    {
        $sum = 0;
        foreach ($this->getDonation() as $don){
            if ($don->getHonoredAt()){
                $sum+=$don->getAmount();
            }
        }
        return $sum;
    }

    public function getSommeDonationNotHonored(): ?int
    {
        $sum = 0;
        foreach ($this->getDonation() as $don){
            if ($don->getHonoredAt()==null){
                $sum+=$don->getAmount();
            }
        }
        return $sum;
    }

    public function getTauxConversion()
    {
        $nbHonored = 0;
        $nbNothonored = 0;
        foreach ($this->getDonation() as $don){

            if ($don->getHonoredAt()){
                $nbHonored+=1;
            }
            else{
                $nbNothonored+=1;
            }
        }
        $txConversion = ($nbHonored/($nbHonored+$nbNothonored))*100;
        return round($txConversion,2);
    }

    public function getNbHonored()
    {
        $nbHonored = 0;

        foreach ($this->getDonation() as $don){

            if ($don->getHonoredAt()){
                $nbHonored+=1;
            }

        }
        return $nbHonored;
    }

    public function getNbNotHonored()
    {
        $nbNotHonored = 0;

        foreach ($this->getDonation() as $don){

            if ($don->getHonoredAt()==null){
                $nbNotHonored+=1;
            }

        }
        return $nbNotHonored;
    }



}
