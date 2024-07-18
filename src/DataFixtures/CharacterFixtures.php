<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Enums\References;
use App\Entity\Character;
use App\Enums\Character\CharacterGender;
use App\Enums\Character\CharacterStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CharacterFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $genderValues = array_column(CharacterGender::cases(), 'value');
        $statusValues = array_column(CharacterStatus::cases(), 'value');

        for ($i = 0; $i < 10; ++$i) {
            $character = new Character();

            $character->setName(sprintf('Character %d', $i));
            $character->setImage(sprintf('%d.jpg', $i));
            $character->setStatus($statusValues[array_rand($statusValues)]);
            $character->setSpecies(sprintf('CharacterSpecies %d', $i));
            $character->setType(sprintf('CharacterType %d', $i));
            $character->setGender($genderValues[array_rand($genderValues)]);

            $character->setOrigin($this->getReference(References::LOCATION->value.rand(0, 9)));
            $character->setLastLocation($this->getReference(References::LOCATION->value.rand(0, 9)));

            $character->addEpisode($this->getReference(References::EPISODE->value.rand(0, 9)));

            $manager->persist($character);

            $this->addReference(References::CHARACTER->value.$i, $character);
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
