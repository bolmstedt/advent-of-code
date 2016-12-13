<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D13\Helpers;

final class Plan
{
    private $favoriteNumber;
    private $plan = [];
    private $visited = [];

    public function __construct($favoriteNumber)
    {
        $this->favoriteNumber = $favoriteNumber;
    }

    public function visit($xPos, $yPos)
    {
        $this->visited[$xPos][$yPos] = true;
    }

    public function numberOfVisited()
    {
        return array_reduce($this->visited, function ($visited, $row) {
            $visited += count($row);

            return $visited;
        }, 0);
    }

    public function isFree($xPos, $yPos)
    {
        if ($xPos < 0 || $yPos < 0) {
            return false;
        }

        if (isset($this->plan[$xPos][$yPos]) === false) {
            $this->plan[$xPos][$yPos] = ($this->isWall($xPos, $yPos) === false);
        }

        if (isset($this->visited[$xPos][$yPos]) === true) {
            return false;
        }

        return $this->plan[$xPos][$yPos];
    }

    protected function isWall($xPos, $yPos)
    {
        $number = ($this->favoriteNumber + $xPos*$xPos + 3*$xPos + 2*$xPos*$yPos + $yPos + $yPos*$yPos);
        $binary = decbin($number);

        return (bool) (strlen(str_replace('0', '', $binary)) % 2);
    }
}
