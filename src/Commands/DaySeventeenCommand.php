<?php

namespace Aoc\Commands;

use Aoc\Helpers\DaySixteen\Sue;

final class DaySeventeenCommand extends DayCommandAbstract
{
    protected $day          = 17;
    protected $description  = 'No Such Thing as Too Much';
    protected $testFunction = [
        1 => 'testOne',
        2 => 'testTwo',
    ];
    protected $testData     = [
        1 => [
            [
                'input' => [
                    20,
                    15,
                    10,
                    5,
                    5,
                ],
                'output' => 4,
            ]
        ],
        2 => [
            [
                'input' => [
                    20,
                    15,
                    10,
                    5,
                    5,
                ],
                'output' => 3,
            ]
        ],
    ];
    protected $correct = 0;
    protected $correctSize = [];

    protected function processPayload($payload)
    {
        return explode(PHP_EOL, $payload);
    }

    protected function initPart()
    {
        $this->correct = 0;
        $this->correctSize = [];
    }

    protected function testOne($input)
    {
        $this->combinations(25, $input);
        return $this->correct;
    }

    protected function testTwo($input)
    {
        $this->combinations(25, $input);
        return $this->getLowestCorrect();
    }

    protected function combinations($volume, $containers, $configuration = [])
    {
        $length = count($containers);

        if (empty($configuration) === false && array_sum($configuration) === $volume) {
            $this->correct++;
            $size = count($configuration);
            if (isset($this->correctSize[$size]) === false) {
                $this->correctSize[$size] = 0;
            }
            $this->correctSize[$size]++;
        }

        for ($i = 0; $i < $length; $i++) {
            if (count($containers) > 0) {
                list($container) = array_splice($containers, 0, 1);
                $this->combinations($volume, $containers, array_merge($configuration, [$container]));
            }
        }
    }

    protected function getLowestCorrect()
    {
        ksort($this->correctSize);
        reset($this->correctSize);
        return current($this->correctSize);
    }

    protected function partOne($input)
    {
        $this->combinations(150, $input);
        return $this->correct;
    }

    protected function partTwo($input)
    {
        $this->combinations(150, $input);
        return $this->getLowestCorrect();
    }
}
