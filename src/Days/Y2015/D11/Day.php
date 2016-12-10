<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D11;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Corporate Policy';
    protected $testFunction = [
        'one' => 'partOne',
        'two' => 'partOne',
    ];
    protected $testData = [
        'one' => [
            'abcdefgh' => 'abcdffaa',
            'ghijklmn' => 'ghjaabcc',
        ],
        'two' => [
            'abcdefgh' => 'abcdffaa',
            'ghijklmn' => 'ghjaabcc',
        ],
    ];

    protected function getNextValidPassword($password)
    {
        do {
            ++$password;
        } while ($this->isValid($password) === false);

        return $password;
    }

    protected function isValid($password)
    {
        return 1 === preg_match("/(?=.*(\\w)\\1.*(\\w)\\2)(?=.*(?:abc|bcd|cde|def|efg|fgh|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz))(?!.*(?:i|o|l))^.+$/", $password);
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
