<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Location
{
    use Timestampable;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'locations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?LocationType $type = null;

    #[ORM\ManyToOne(inversedBy: 'locations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?LocationDimension $dimension = null;

    /**
     * @var Collection<int, Character>
     */
    #[ORM\OneToMany(targetEntity: Character::class, mappedBy: 'origin', orphanRemoval: true)]
    private Collection $characters;

    #[ORM\OneToMany(targetEntity: Character::class, mappedBy: 'lastLocation', orphanRemoval: true)]
    private Collection $residents;

    public function __construct()
    {
        $this->characters = new ArrayCollection();
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

    public function getType(): ?LocationType
    {
        return $this->type;
    }

    public function setType(?LocationType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDimension(): ?LocationDimension
    {
        return $this->dimension;
    }

    public function setDimension(?LocationDimension $dimension): static
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * @return Collection<int, Character>
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Character $character): static
    {
        if (!$this->characters->contains($character)) {
            $this->characters->add($character);
            $character->setOrigin($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): static
    {
        if ($this->characters->removeElement($character)) {
            // set the owning side to null (unless already changed)
            if ($character->getOrigin() === $this) {
                $character->setOrigin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Character>
     */
    public function getResidents(): Collection
    {
        return $this->residents;
    }

    public function addResident(Character $resident): static
    {
        if (!$this->residents->contains($resident)) {
            $this->residents->add($resident);
            $resident->setLastLocation($this);
        }
        return $this;
    }

    public function removeResident(Character $resident): static
    {
        if ($this->residents->removeElement($resident)) {
            // set the owning side to null (unless already changed)
            if ($resident->getLastLocation() === $this) {
                $resident->setLastLocation(null);
            }
        }
        return $this;
    }
}
