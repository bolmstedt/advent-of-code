<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D06;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Probably a Fire Hazard';
    protected $lights = [];

    protected function processPayload($payload)
    {
        return explode(PHP_EOL, $payload);
    }

    protected function initPart()
    {
        $this->lights = array_fill_keys(range(0, 999999), 0);
    }

    protected function processOperation($input, $part)
    {
        $parts = explode(' ', ucwords($input));
        $upper = explode(',', array_pop($parts));
        array_pop($parts);
        $lower = explode(',', array_pop($parts));
        $operation = $part.implode($parts);

        return [$operation, $lower, $upper];
    }

    protected function getLights()
    {
        return array_sum($this->lights);
    }

    protected function doOperation($input, $part)
    {
        $input = $this->processOperation($input, $part);

        for ($x = $input[1][0]; $x <= $input[2][0]; ++$x) {
            for ($y = $input[1][1]; $y <= $input[2][1]; ++$y) {
                $this->{$input[0]}($x+$y*1000);
            }
        }
    }

    protected function oneTurnOn($pos)
    {
        $this->lights[$pos] = 1;
    }

    protected function oneTurnOff($pos)
    {
        $this->lights[$pos] = 0;
    }

    protected function oneToggle($pos)
    {
        $this->lights[$pos] = $this->lights[$pos] === 0 ? 1 : 0;
    }

    protected function twoTurnOn($pos)
    {
        $this->lights[$pos] += 1;
    }

    protected function twoTurnOff($pos)
    {
        $this->lights[$pos] = max(0, $this->lights[$pos]-1);
    }

    protected function twoToggle($pos)
    {
        $this->lights[$pos] += 2;
    }

    protected function partOne($input)
    {
        foreach ($input as $row) {
            $this->doOperation($row, 'one');
        }

        return $this->getLights();
    }

    protected function partTwo($input)
    {
        foreach ($input as $row) {
            $this->doOperation($row, 'two');
        }

        return $this->getLights();
    }
}
