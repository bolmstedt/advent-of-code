<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D01;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'No Time for a Taxicab';
    protected $testData = [
        'one' => [
            'R2, L3' => 5,
            'R2, R2, R2' => 2,
            'R5, L5, R5, R3' => 12,
        ],
        'two' => [
            'R8, R4, R4, R8' => 4,
        ],
    ];

    protected function initPart()
    {
        $this->xPos = 0;
        $this->yPos = 0;
        $this->currentDirection = 'north';
        $this->compass = ['east', 'south', 'west'];
        $this->visited = [];
    }

    protected function processPayload($input)
    {
        return explode(', ', $input);
    }

    protected function turnLeft()
    {
        array_unshift($this->compass, $this->currentDirection);
        $this->currentDirection = array_pop($this->compass);
    }

    protected function turnRight()
    {
        array_push($this->compass, $this->currentDirection);
        $this->currentDirection = array_shift($this->compass);
    }

    protected function turn($direction)
    {
        if ($direction === 'R') {
            $this->turnRight();

            return;
        }

        $this->turnLeft();
    }

    protected function turnAndGetDistance($step)
    {
        $this->turn(substr($step, 0, 1));

        return (int) substr($step, 1);
    }

    protected function move($distance)
    {
        switch ($this->currentDirection) {
            case 'north':
                return $this->xPos += $distance;
            case 'east':
                return $this->yPos += $distance;
            case 'south':
                return $this->xPos -= $distance;
            case 'west':
                return $this->yPos -= $distance;
        }
    }

    protected function walk($steps)
    {
        foreach ($steps as $step) {
            $distance = $this->turnAndGetDistance($step);
            $this->move($distance);
        }
    }

    protected function hasBeenHere()
    {
        $location = $this->xPos.','.$this->yPos;

        if (in_array($location, $this->visited, true) === true) {
            return true;
        }

        $this->visited[] = $location;

        return false;
    }

    protected function walkUntilRevisit($steps)
    {
        foreach ($steps as $step) {
            $distance = $this->turnAndGetDistance($step);

            while ($distance > 0) {
                $this->move(1);

                if ($this->hasBeenHere() === true) {
                    return;
                }

                --$distance;
            }
        }
    }

    protected function distanceFromOrigin()
    {
        return abs($this->xPos) + abs($this->yPos);
    }

    protected function partOne($input)
    {
        $this->walk($input);

        return $this->distanceFromOrigin();
    }

    protected function partTwo($input)
    {
        $this->walkUntilRevisit($input);

        return $this->distanceFromOrigin();
    }
}
