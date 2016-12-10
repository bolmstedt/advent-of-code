<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D04;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'The Ideal Stocking Stuffer';
    protected $testData = [
        'one' => [
            'abcdef' => 609043,
            'pqrstuv' => 1048970,
        ],
        'two' => [
            'abcdef' => 6742839,
        ],
    ];

    protected function findZeroHash($key, $length)
    {
        $integer = 0;
        $match = str_repeat('0', $length);

        do {
            ++$integer;
        } while (strpos(md5($key.$integer), $match) !== 0);

        return $integer;
    }

    protected function partOne($input)
    {
        return $this->findZeroHash($input, 5);
    }

    protected function partTwo($input)
    {
        return $this->findZeroHash($input, 6);
    }
}
