<?php

namespace Aoc\Commands;

final class DayNineteenCommand extends DayCommandAbstract
{
    protected $day          = 19;
    protected $description  = 'Medicine for Rudolph';
    protected $testFunction = [
        1 => 'testOne',
        2 => 'testTwo',
    ];
    protected $testData     = [
        1 => [
            [
                'input' => [
                    'H => HO',
                    'H => OH',
                    'O => HH',
                    'HOH',
                ],
                'output' => 4,
            ],
            [
                'input' => [
                    'H => HO',
                    'H => OH',
                    'O => HH',
                    'HOHOHO',
                ],
                'output' => 7,
            ],
        ],
        2 => [
            [
                'input' => [
                    'e => H',
                    'e => O',
                    'H => HO',
                    'H => OH',
                    'O => HH',
                    'HOH',
                ],
                'output' => 3,
            ],
            [
                'input' => [
                    'e => H',
                    'e => O',
                    'H => HO',
                    'H => OH',
                    'O => HH',
                    'HOHOHO',
                ],
                'output' => 6,
            ],
        ],
    ];
    protected $replacements = [];
    protected $search       = [];
    protected $replace      = [];
    protected $target;
    protected $foundAt;

    protected function processPayload($payload)
    {
        return array_filter(explode(PHP_EOL, $payload));
    }

    protected function testOne($input)
    {
        $this->setUpReplacements($input);
        $molecules = $this->createMoleculesFrom($this->target);
        return count($molecules);
    }

    protected function testTwo($input)
    {
        $this->setUpReplacements($input);
        do {
            list($molecule, $count) = $this->reduceToQuick($this->target);
        } while (strlen(str_replace('e', '', $molecule)) > 0);
        return $count;
    }

    protected function reduceToQuick($target, $currentCount = 0)
    {
        $molecule = str_replace($this->search, $this->replace, $target, $count);
        return [$molecule, $currentCount + $count];
    }

    protected function reduceTo($molecule, $steps = 1)
    {
        $molecules = $this->reduceMoleculesFrom($molecule, $steps);
        foreach (array_keys($molecules) as $molecule) {
            $this->reduceTo($molecule, $steps + 1);
        }
    }

    protected function setUpReplacements($input)
    {
        $this->target       = array_pop($input);
        $this->replacements = [];
        $this->foundAt      = [];
        $this->search       = [];
        $this->replace      = [];

        foreach ($input as $row) {
            $this->replacements[] = explode(' => ', $row);
        }

        foreach ($this->replacements as $row) {
            $this->search[]  = $row[1];
            $this->replace[] = $row[0];
        }

        usort($this->replacements, function ($first, $second) {
            return strlen($second[1]) - strlen($first[1]);
        });
    }

    protected function createMoleculesFrom($current, $steps = 1)
    {
        $molecules = [];
        foreach ($this->replacements as $replace) {
            $needle    = $replace[0];
            $lastPos   = 0;
            $positions = [];

            while (($lastPos = strpos($current, $needle, $lastPos)) !== false) {
                $positions[] = $lastPos;
                $lastPos     = $lastPos + strlen($needle);
            }
            foreach ($positions as $pos) {
                $molecule = substr_replace($current, $replace[1], $pos, strlen($needle));
                if (isset($this->foundAt[$molecule]) === false
                    || $this->foundAt[$molecule] > $steps) {
                    $molecules[$molecule] = $this->foundAt[$molecule] = $steps;
                }
            }
        }
        unset($molecules[$current]);
        return $molecules;
    }

    protected function reduceMoleculesFrom($current, $steps = 1)
    {
        $molecules = [];
        foreach ($this->replacements as $replace) {
            $needle    = $replace[1];
            $lastPos   = 0;
            $positions = [];

            while (($lastPos = strpos($current, $needle, $lastPos)) !== false) {
                $positions[] = $lastPos;
                $lastPos     = $lastPos + strlen($needle);
            }
            foreach ($positions as $pos) {
                $molecule = substr_replace($current, $replace[0], $pos, strlen($needle));
                if ((strpos($molecule, 'e') === false || $molecule === 'e') &&
                    (isset($this->foundAt[$molecule]) === false || $this->foundAt[$molecule] > $steps)) {
                    $molecules[$molecule] = $this->foundAt[$molecule] = $steps;
                }
            }
        }
        unset($molecules[$current]);
        return $molecules;
    }

    protected function partOne($input)
    {
        $this->setUpReplacements($input);
        $molecules = $this->createMoleculesFrom($this->target);
        return count($molecules);
    }

    protected function partTwo($input)
    {
        $this->setUpReplacements($input);
        $molecule = $this->target;
        $count = 0;
        do {
            list($molecule, $count) = $this->reduceToQuick($molecule, $count);
        } while (strlen(str_replace('e', '', $molecule)) > 0);
        return $count;
    }
}
