<?php

namespace Aoc\Commands;

use Aoc\Helpers\DayFourteen\Race;
use Aoc\Helpers\DayFourteen\Reindeer;

final class DayFourteenCommand extends DayCommandAbstract
{
    protected $day          = 14;
    protected $description  = 'Reindeer Olympics';
    protected $testFunction = [
        1 => 'testOne',
        2 => 'testTwo',
    ];
    protected $testData     = [
        1 => [
            1000 => 1120,
        ],
        2 => [
            1000 => 689,
        ]
    ];
    protected $race;

    protected function processPayload($payload)
    {
        return explode(PHP_EOL, $payload);
    }

    protected function testOne($input)
    {
        $reindeer = [
            'Comet can fly 14 km/s for 10 seconds, but then must rest for 127 seconds.',
            'Dancer can fly 16 km/s for 11 seconds, but then must rest for 162 seconds.',
        ];
        $this->race = new Race();
        $this->addReindeer($reindeer);
        $this->race->raceForSeconds($input);
        return $this->race->getDistanceWinner()->getDistance();
    }

    protected function testTwo($input)
    {
        $reindeer = [
            'Comet can fly 14 km/s for 10 seconds, but then must rest for 127 seconds.',
            'Dancer can fly 16 km/s for 11 seconds, but then must rest for 162 seconds.',
        ];
        $this->race = new Race();
        $this->addReindeer($reindeer);
        $this->race->raceForSeconds($input);
        return $this->race->getPointsWinner()->getPoints();
    }

    protected function addReindeer($reindeer)
    {
        foreach ($reindeer as $caribou) {
            $this->race->addReindeer(new Reindeer($caribou));
        }
    }

    protected function partOne($input)
    {
        $this->race = new Race();
        $this->addReindeer($input);
        $this->race->raceForSeconds(2503);
        return $this->race->getDistanceWinner()->getDistance();
    }

    protected function partTwo($input)
    {
        $this->race = new Race();
        $this->addReindeer($input);
        $this->race->raceForSeconds(2503);
        return $this->race->getPointsWinner()->getPoints();
    }
}
