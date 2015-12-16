<?php

namespace Aoc\Commands;

final class DayEightCommand extends DayCommandAbstract
{
    protected $day          = 8;
    protected $description  = 'Matchsticks';
    protected $testFunction = [
        1 => 'testOne',
        2 => 'testTwo',
    ];
    protected $testData     = [
        1 => [
            '""'         => 2,
            '"abc"'      => 2,
            '"aaa\"aaa"' => 3,
            '"\x27"'     => 5,
        ],
        2 => [
            '""'         => 4,
            '"abc"'      => 4,
            '"aaa\"aaa"' => 6,
            '"\x27"'     => 5,
        ]
    ];

    protected function processPayload($payload)
    {
        return explode(PHP_EOL, $payload);
    }

    protected function testOne($input)
    {
        return $this->stringLiteralLength($input);
    }

    protected function testTwo($input)
    {
        return $this->escapeStringLiteralLength($input);
    }

    protected function escapeStringLiteralLength($input)
    {
        return $this->stringLiteralLength('"'.addslashes($input).'"');
    }

    protected function stringLiteralLength($input)
    {
        $parsed = eval("return $input;");
        return strlen($input) - strlen($parsed);
    }

    protected function partOne($input)
    {
        return array_reduce($input, function ($length, $string) {
            return $length + $this->stringLiteralLength($string);
        });
    }

    protected function partTwo($input)
    {
        return array_reduce($input, function ($length, $string) {
            return $length + $this->escapeStringLiteralLength($string);
        });
    }
}
