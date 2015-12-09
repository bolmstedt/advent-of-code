<?php

namespace Aoc\Commands;

final class DaySixCommand extends DayCommandAbstract
{
    protected $day          = 6;
    protected $description  = 'Probably a Fire Hazard';
    protected $testFunction = [
        1 => 'testOneOperation',
        2 => 'testTwoOperation',
    ];
    protected $testData     = [
        1 => [
            'turn on 0,0 through 999,999'      => 1000000,
            'toggle 0,0 through 999,0'         => 999000,
            'toggle 0,0 through 0,999'         => 998002,
            'toggle 0,0 through 0,0'           => 998001,
            'turn off 499,499 through 500,500' => 997997,
        ],
        2 => [
            'turn on 0,0 through 0,0' => 1,
            'turn on 0,0 through 1,1' => 5,
            'turn on 1,1 through 1,1' => 6,
            'turn off 0,0 through 0,1' => 4,
            'turn off 0,0 through 0,2' => 3,
            'turn off 0,0 through 0,3' => 3,
            'toggle 0,0 through 999,999' => 2000003,
        ]
    ];
    protected $lights = [];

    protected function processPayload($payload)
    {
        return explode(PHP_EOL, $payload);
    }

    protected function initPart()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(120);
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

    protected function testOneOperation($input)
    {
        $this->doOperation($input, 'one');
        return $this->getLights();
    }

    protected function testTwoOperation($input)
    {
        $this->doOperation($input, 'two');
        return $this->getLights();
    }

    protected function doOperation($input, $part)
    {
        $input = $this->processOperation($input, $part);

        for ($x = $input[1][0]; $x <= $input[2][0]; $x++) {
            for ($y = $input[1][1]; $y <= $input[2][1]; $y++) {
                $this->$input[0]($x+$y*1000);
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
