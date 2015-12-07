<?php

namespace Aoc\Commands;

final class DayFourCommand extends DayCommandAbstract
{
    protected $day          = 'four';
    protected $testFunction = [
        1 => 'findFiveZeroHash',
        2 => 'findSixZeroHash',
    ];
    protected $testData     = [
        1 => [
            'abcdef' => 609043,
            'pqrstuv' => 1048970,
        ],
        2 => [
            'abcdef' => 6742839,
        ]
    ];

    protected function findFiveZeroHash($key)
    {
        return $this->findZeroHash($key, 5);
    }

    protected function findSixZeroHash($key)
    {
        return $this->findZeroHash($key, 6);
    }

    protected function findZeroHash($key, $length)
    {
        $integer = 0;
        $match = str_repeat('0', $length);
        do {
            $integer++;
        } while (strpos(md5($key.$integer), $match) !== 0);
        return $integer;
    }

    protected function partOne($input)
    {
        return $this->findFiveZeroHash($input);
    }

    protected function partTwo($input)
    {
        return $this->findSixZeroHash($input);
    }
}
