<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D05;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Doesn\'t He Have Intern-Elves For This?';
    protected $testData = [
        'one' => [
            'ugknbfddgicrmopn' => 1,
            'aaa' => 1,
            'jchzalrnumimnmhp' => 0,
            'haegwjzuvuyypxyu' => 0,
            'dvszwmarrgswjxmb' => 0,
        ],
        'two' => [
            'qjhvhtzxzqqjkmpb' => 1,
            'xxyxx' => 1,
            'uurcxstgmygtbstg' => 0,
            'ieodomkazucvgmuy' => 0,
        ],
    ];

    protected function processPayload($payload)
    {
        return explode(PHP_EOL, $payload);
    }

    protected function isNiceString($string)
    {
        return preg_match("/(?=.*([\w])\\1)(?=(.*[aeiou]){3,})(?!.*(ab|cd|pq|xy))^.+$/i", $string);
    }

    protected function isReallyNiceString($string)
    {
        return preg_match("/(?=.*(\\w{2}).*\\1)(?=.*(\\w)\\w\\2)^.+$/i", $string);
    }

    protected function reduce($function, $input)
    {
        return array_reduce($input, function ($nice, $string) use ($function) {
            return $nice + $this->$function($string);
        });
    }

    protected function partOne($input)
    {
        return $this->reduce('isNiceString', $input);
    }

    protected function partTwo($input)
    {
        return $this->reduce('isReallyNiceString', $input);
    }
}
