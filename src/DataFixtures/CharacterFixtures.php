<?php

namespace App\DataFixtures;

use App\DataFixtures\Enums\References;
use App\Entity\Character;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CharacterFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 9; $i++) {
            $character = new Character();

            $character->setName(sprintf('Character %d', $i));
            $character->setImage(sprintf('character%d.jpg', $i));
            $character->setStatus(sprintf('CharacterStatus %d', $i));
            $character->setSpecies(sprintf('CharacterSpecies %d', $i));
            $character->setType(sprintf('CharacterType %d', $i));
            $character->setGender(sprintf('CharacterGender %d', $i));

            $character->setOrigin($this->getReference(References::LOCATION->value . rand(0, 9)));
            $character->setLastLocation($this->getReference(References::LOCATION->value . rand(0, 9)));

            $character->addEpisode($this->getReference(References::EPISODE->value . rand(0, 9)));

            $manager->persist($character);

            $this->addReference(References::CHARACTER->value . $i, $character);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LocationFixtures::class,
            EpisodeFixtures::class,
        ];
    }
}
