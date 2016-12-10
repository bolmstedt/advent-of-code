<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D16;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Aunt Sue';
    protected $testFunction = [
        'one' => 'test',
        'two' => 'test',
    ];
    protected $testData = [
        'one' => [
            'input' => 'input',
        ],
        'two' => [
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
        return current($input);
    }

    protected function partOne($input)
    {
        $clueSue = new Helpers\Sue($this->clues);

        foreach ($input as $sue) {
            $who = new Helpers\Sue($sue);

            if ($who->compare($clueSue) === true) {
                return $who->getNumber();
            }
        }
    }

    protected function partTwo($input)
    {
        $clueSue = new Helpers\Sue($this->clues);

        foreach ($input as $sue) {
            $who = new Helpers\Sue($sue);

            if ($who->compareClosely($clueSue) === true) {
                return $who->getNumber();
            }
        }
    }
}
