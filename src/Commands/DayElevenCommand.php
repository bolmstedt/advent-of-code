<?php

namespace Aoc\Commands;

final class DayElevenCommand extends DayCommandAbstract
{
    protected $day          = 11;
    protected $description  = 'Corporate Policy';
    protected $testFunction = [
        1 => 'test',
        2 => 'test',
    ];
    protected $testData     = [
        1 => [
            'abcdefgh' => 'abcdffaa',
            'ghijklmn' => 'ghjaabcc',
        ],
        2 => [
            'abcdefgh' => 'abcdffaa',
        ]
    ];

    protected $straights = [
        'abc',
        'bcd',
        'cde',
        'def',
        'efg',
        'fgh',
        'pqr',
        'qrs',
        'rst',
        'stu',
        'tuv',
        'uvw',
        'vwx',
        'wxy',
        'xyz',
    ];

    protected function test($input)
    {
        return $this->getNextValidPassword($input);
    }

    protected function getNextValidPassword($password)
    {
        do {
        } while ($this->isValid(++$password) === false);

        return $password;
    }

    protected function isValid($password)
    {
        return 1 === preg_match("/(?=.*(\\w)\\1.*(\\w)\\2)(?=.*(?:".implode('|', $this->straights)."))(?!.*(?:i|o|l))^.+$/", $password);
    }

    protected function partOne($input)
    {
        return $this->getNextValidPassword($input);
    }

    protected function partTwo($input)
    {
        return $this->getNextValidPassword($this->getNextValidPassword($input));
    }
}
