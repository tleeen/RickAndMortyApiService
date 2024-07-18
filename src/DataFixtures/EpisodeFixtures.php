<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Enums\References;
use App\Entity\Episode;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $episode = new Episode();

            $randomTimestamp = rand(strtotime('-1 year'), time());
            $randomDate = new DateTime();
            $randomDate->setTimestamp($randomTimestamp);

            $episode->setAirDate($randomDate);
            $episode->setName(sprintf('Episode %d', $i));
            $episode->setCode(sprintf('S0%dE0%d', $i + 1, $i + 1));

            $manager->persist($episode);

            $this->addReference(References::EPISODE->value . $i, $episode);
        }

        $manager->flush();
    }
}
