<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D01;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Not Quite Lisp';
    protected $testData = [
        'one' => [
            '(())' => 0,
            '()()' => 0,
            '(((' => 3,
            '(()(()(' => 3,
            '))(((((' => 3,
            '())' => -1,
            '))(' => -1,
            ')))' => -3,
            ')())())' => -3,
        ],
        'two' => [
            ')' => 1,
            '()())' => 5,
        ],
    ];

    protected function calculateFloor($input)
    {
        $floorsDown = strlen(str_replace('(', '', $input));
        $floorsUp = strlen(str_replace(')', '', $input));

        return -$floorsDown + $floorsUp;
    }

    protected function calculateBasement($input)
    {
        $length = strlen($input);
        $floor = 0;

        for ($i = 0; $i < $length; ++$i) {
            $floor += ($input[$i] === '(') ? 1 : -1;

            if ($floor < 0) {
                return $i + 1;
            }
        }
    }

    protected function partOne($input)
    {
        return $this->calculateFloor($input);
    }

    protected function partTwo($input)
    {
        return $this->calculateBasement($input);
    }
}
