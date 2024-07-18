<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Enums\References;
use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LocationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $location = new Location();

            $location->setName(sprintf('Location %d', $i));
            $location->setType(sprintf('LocationType %d', $i));
            $location->setDimension(sprintf('LocationDimension %d', $i));

            $manager->persist($location);

            $this->addReference(References::LOCATION->value . $i, $location);
        }

        $manager->flush();
    }
}
