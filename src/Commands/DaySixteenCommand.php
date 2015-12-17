<?php

namespace Aoc\Commands;

use Aoc\Helpers\DaySixteen\Sue;

final class DaySixteenCommand extends DayCommandAbstract
{
    protected $day          = 16;
    protected $description  = 'Aunt Sue';
    protected $testFunction = [
        1 => 'test',
        2 => 'test',
    ];
    protected $testData     = [
        1 => [
            'input' => 'input',
        ],
        2 => [
            'input' => 'input',
        ],
    ];
    protected $clues = 'Sue 0:
            children: 3,
            cats: 7,
            samoyeds: 2,
            pomeranians: 3,
            akitas: 0,
            vizslas: 0,
            goldfish: 5,
            trees: 3,
            cars: 2,
            perfumes: 1';

    protected function processPayload($payload)
    {
        return explode(PHP_EOL, $payload);
    }

    protected function test($input)
    {
        return $input;
    }

    protected function partOne($input)
    {
        $clueSue = new Sue($this->clues);

        foreach ($input as $sue) {
            $who = new Sue($sue);

            if ($who->compare($clueSue) === true) {
                return $who->getNumber();
            }
        }
    }

    protected function partTwo($input)
    {
        $clueSue = new Sue($this->clues);

        foreach ($input as $sue) {
            $who = new Sue($sue);

            if ($who->compareClosely($clueSue) === true) {
                return $who->getNumber();
            }
        }
    }
}
