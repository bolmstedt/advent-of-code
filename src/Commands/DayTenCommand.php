<?php

namespace Aoc\Commands;

final class DayTenCommand extends DayCommandAbstract
{
    protected $day          = 10;
    protected $description  = 'Elves Look, Elves Say';
    protected $testFunction = [
        1 => 'testOne',
        2 => 'testTwo',
    ];
    protected $testData     = [
        1 => [
            1      => 11,
            11     => 21,
            21     => 1211,
            1211   => 111221,
            111221 => 312211,
        ],
        2 => [
            1      => 2,
            11     => 2,
            21     => 4,
            1211   => 6,
            111221 => 6,
        ]
    ];

    protected function testOne($input)
    {
        return (int) $this->lookAndSay($input);
    }

    protected function testTwo($input)
    {
        return strlen($this->lookAndSay($input));
    }

    protected function lookAndSay($input)
    {
        return preg_replace_callback(
            '/(\\d)\\1*/',
            function ($matches) {
                return strlen($matches[0]).$matches[1];
            },
            $input
        );
    }

    protected function partOne($input)
    {
        for ($i = 0; $i < 40; $i++) {
            $input = $this->lookAndSay($input);
        }

        return strlen($input);
    }

    protected function partTwo($input)
    {
        for ($i = 0; $i < 50; $i++) {
            $input = $this->lookAndSay($input);
        }

        return strlen($input);
    }
}
