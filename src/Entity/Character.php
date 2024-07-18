<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\Character\CharacterRepository;
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

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    private ?string $species = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $gender = null;

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

    public function setName(string $name): Character
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): Character
    {
        $this->image = $image;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): Character
    {
        $this->status = $status;
        return $this;
    }

    public function getSpecies(): ?string
    {
        return $this->species;
    }

    public function setSpecies(?string $species): Character
    {
        $this->species = $species;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): Character
    {
        $this->type = $type;
        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): Character
    {
        $this->gender = $gender;
        return $this;
    }

    public function getOrigin(): ?Location
    {
        return $this->origin;
    }

    public function setOrigin(?Location $origin): Character
    {
        $this->origin = $origin;

        return $this;
    }

    public function getLastLocation(): ?Location
    {
        return $this->lastLocation;
    }

    public function setLastLocation(?Location $lastLocation): Character
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

    public function addEpisode(Episode $episode): Character
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes->add($episode);
            $episode->addCharacter($this);
        }
        return $this;
    }

    public function removeEpisode(Episode $episode): Character
    {
        if ($this->episodes->removeElement($episode)) {
            $episode->removeCharacter($this);
        }
        return $this;
    }
}
