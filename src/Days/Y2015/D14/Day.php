<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D14;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Reindeer Olympics';
    protected $testFunction = [
        'one' => 'testOne',
        'two' => 'testTwo',
    ];

    protected function processPayload($payload)
    {
        return explode(PHP_EOL, $payload);
    }

    protected function testOne($input)
    {
        $race = $this->raceFor($input, 1000);

        return $race->getDistanceWinner()->getDistance();
    }

    protected function testTwo($input)
    {
        $race = $this->raceFor($input, 1000);

        return $race->getPointsWinner()->getPoints();
    }

    protected function raceFor($reindeer, $seconds)
    {
        $race = new Helpers\Race();

        foreach ($reindeer as $caribou) {
            $race->addReindeer(new Helpers\Reindeer($caribou));
        }

        $race->raceForSeconds($seconds);

        return $race;
    }

    protected function partOne($input)
    {
        $race = $this->raceFor($input, 2503);

        return $race->getDistanceWinner()->getDistance();
    }

    protected function partTwo($input)
    {
        $race = $this->raceFor($input, 2503);

        return $race->getPointsWinner()->getPoints();
    }
}
