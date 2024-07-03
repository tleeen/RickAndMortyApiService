<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Character
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CharacterStatus $status = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CharacterSpecies $species = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    private ?CharacterSubspecies $subspecies = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CharacterGender $gender = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $origin = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    private ?Location $lastLocation = null;

    /**
     * @var Collection<int, Episode>
     */
    #[ORM\ManyToMany(targetEntity: Episode::class, mappedBy: 'characters')]
    private Collection $episodes;

    public function __construct()
    {
        $this->episodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getStatus(): ?CharacterStatus
    {
        return $this->status;
    }

    public function setStatus(?CharacterStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getSpecies(): ?CharacterSpecies
    {
        return $this->species;
    }

    public function setSpecies(?CharacterSpecies $species): static
    {
        $this->species = $species;

        return $this;
    }

    public function getSubspecies(): ?CharacterSubspecies
    {
        return $this->subspecies;
    }

    public function setSubspecies(?CharacterSubspecies $subspecies): static
    {
        $this->subspecies = $subspecies;

        return $this;
    }

    public function getGender(): ?CharacterGender
    {
        return $this->gender;
    }

    public function setGender(?CharacterGender $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getOrigin(): ?Location
    {
        return $this->origin;
    }

    public function setOrigin(?Location $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    public function getLastLocation(): ?Location
    {
        return $this->lastLocation;
    }

    public function setLastLocation(?Location $lastLocation): static
    {
        $this->lastLocation = $lastLocation;

        return $this;
    }

    /**
     * @return Collection<int, Episode>
     */
    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    public function addEpisode(Episode $episode): static
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes->add($episode);
            $episode->addCharacter($this);
        }

        return $this;
    }

    public function removeEpisode(Episode $episode): static
    {
        if ($this->episodes->removeElement($episode)) {
            $episode->removeCharacter($this);
        }

        return $this;
    }
}
