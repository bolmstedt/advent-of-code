<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D13;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'A Maze of Twisty Little Cubicles';
    protected $testFunction = ['one' => 'partOneTest', 'two' => 'partTwoTest'];
    protected $testData = [
        'one' => [
            10 => 11,
        ],
        'two' => [
            10 => 20,
        ],
    ];

    protected function doStep(array $walkers)
    {
        $newWalkers = [];

        foreach ($walkers as $walker) {
            $newWalkers = array_merge($newWalkers, $walker->walk());
        }

        return $newWalkers;
    }

    protected function isDone($walkers, $xPos, $yPos)
    {
        foreach ($walkers as $walker) {
            if ($walker->getX() === $xPos && $walker->getY() === $yPos) {
                return true;
            }
        }

        return false;
    }

    protected function getShortestRoute($input, $xPos, $yPos)
    {
        $steps = 0;
        $plan = new Helpers\Plan($input);
        $walkers = [new Helpers\Walker($plan, 1, 1)];

        while ($this->isDone($walkers, $xPos, $yPos) === false) {
            ++$steps;
            $walkers = $this->doStep($walkers);
        }

        return $steps;
    }

    protected function partOneTest($input)
    {
        return $this->getShortestRoute($input, 7, 4);
    }

    protected function partOne($input)
    {
        return $this->getShortestRoute($input, 31, 39);
    }

    protected function walkFor($input, $steps)
    {
        $plan = new Helpers\Plan($input);
        $walkers = [new Helpers\Walker($plan, 1, 1)];

        while ($steps > 0) {
            --$steps;
            $walkers = $this->doStep($walkers);
        }

        return $plan->numberOfVisited();
    }

    protected function partTwoTest($input)
    {
        return $this->walkFor($input, 11);
    }

    protected function partTwo($input)
    {
        return $this->walkFor($input, 50);
    }
}
