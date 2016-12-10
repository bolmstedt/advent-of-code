<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D08;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Matchsticks';
    protected $testData = [
        'one' => [
            '""' => 2,
            '"abc"' => 2,
            '"aaa\"aaa"' => 3,
            '"\x27"' => 5,
        ],
        'two' => [
            '""' => 4,
            '"abc"' => 4,
            '"aaa\"aaa"' => 6,
            '"\x27"' => 5,
        ],
    ];

    protected function processPayload($payload)
    {
        return explode(PHP_EOL, $payload);
    }

    protected function escapeStringLiteralLength($input)
    {
        return $this->stringLiteralLength('"'.addslashes($input).'"');
    }

    /**
     * @SuppressWarnings(PHPMD.EvalExpression)
     */
    protected function stringLiteralLength($input)
    {
        $parsed = eval('return '.$input.';');

        return strlen($input) - strlen($parsed);
    }

    protected function partOne($input)
    {
        return array_reduce($input, function ($length, $string) {
            return $length + $this->stringLiteralLength($string);
        }, 0);
    }

    protected function partTwo($input)
    {
        return array_reduce($input, function ($length, $string) {
            return $length + $this->escapeStringLiteralLength($string);
        }, 0);
    }
}
