<?php

namespace Aoc\Helpers\DayFourteen;

final class Race
{
    protected $reindeer = [];

    public function addReindeer(Reindeer $reindeer)
    {
        $this->reindeer[] = $reindeer;
    }

    public function raceForSeconds($seconds)
    {
        for ($i = 0; $i < $seconds; $i++) {
            $this->advanceTime();
        }
    }

    public function getDistanceWinner()
    {
        foreach ($this->reindeer as $reindeer) {
            if (isset($leader) === false || $reindeer->getDistance() > $leader->getDistance()) {
                $leader = $reindeer;
            }
        }

        return $leader;
    }

    public function getPointsWinner()
    {
        foreach ($this->reindeer as $reindeer) {
            if (isset($leader) === false || $reindeer->getPoints() > $leader->getPoints()) {
                $leader = $reindeer;
            }
        }

        return $leader;
    }

    protected function advanceTime()
    {
        foreach ($this->reindeer as $reindeer) {
            $reindeer->advance();
        }
        $this->awardPoints();
    }

    protected function awardPoints()
    {
        $leadingDistance = $this->getDistanceWinner()->getDistance();
        foreach ($this->reindeer as $reindeer) {
            if ($reindeer->getDistance() === $leadingDistance) {
                $reindeer->awardPoint();
            }
        }
    }
}
