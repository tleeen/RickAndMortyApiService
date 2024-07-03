<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\CharacterSpeciesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterSpeciesRepository::class)]
#[ORM\HasLifecycleCallbacks]
class CharacterSpecies
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, CharacterSubspecies>
     */
    #[ORM\OneToMany(targetEntity: CharacterSubspecies::class, mappedBy: 'species', orphanRemoval: true)]
    private Collection $characterSubspecies;

    /**
     * @var Collection<int, Character>
     */
    #[ORM\OneToMany(targetEntity: Character::class, mappedBy: 'species', orphanRemoval: true)]
    private Collection $characters;

    public function __construct()
    {
        $this->characterSubspecies = new ArrayCollection();
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

    /**
     * @return Collection<int, CharacterSubspecies>
     */
    public function getCharacterSubspecies(): Collection
    {
        return $this->characterSubspecies;
    }

    public function addCharacterSubspecy(CharacterSubspecies $characterSubspecy): static
    {
        if (!$this->characterSubspecies->contains($characterSubspecy)) {
            $this->characterSubspecies->add($characterSubspecy);
            $characterSubspecy->setSpecies($this);
        }

        return $this;
    }

    public function removeCharacterSubspecy(CharacterSubspecies $characterSubspecy): static
    {
        if ($this->characterSubspecies->removeElement($characterSubspecy)) {
            // set the owning side to null (unless already changed)
            if ($characterSubspecy->getSpecies() === $this) {
                $characterSubspecy->setSpecies(null);
            }
        }

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
            $character->setSpecies($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): static
    {
        if ($this->characters->removeElement($character)) {
            // set the owning side to null (unless already changed)
            if ($character->getSpecies() === $this) {
                $character->setSpecies(null);
            }
        }

        return $this;
    }
}
