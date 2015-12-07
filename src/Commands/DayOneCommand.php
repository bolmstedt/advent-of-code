<?php

namespace Aoc\Commands;

final class DayOneCommand extends DayCommandAbstract
{
    protected $day          = 'one';
    protected $testFunction = [
        1 => 'calculateFloor',
        2 => 'calculateBasement',
    ];
    protected $testData     = [
        1 => [
            '(())'    => 0,
            '()()'    => 0,
            '((('     => 3,
            '(()(()(' => 3,
            '))(((((' => 3,
            '())'     => -1,
            '))('     => -1,
            ')))'     => -3,
            ')())())' => -3,
        ],
        2 => [
            ')'     => 1,
            '()())' => 5
        ]
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
        for ($i=0; $i<$length; $i++) {
            $floor += ($input[$i] === '(') ? 1 : -1;
            if ($floor < 0) {
                return $i + 1;
                break;
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
