<?php

namespace Aoc\Commands;

use Aoc\Helpers\DayFifteen\Dough;
use Aoc\Helpers\DayFifteen\Ingredient;

final class DayFifteenCommand extends DayCommandAbstract
{
    protected $day          = 15;
    protected $description  = 'Science for Hungry People';
    protected $testFunction = [
        1 => 'testOne',
        2 => 'testTwo',
    ];
    protected $testData     = [
        1 => [
            'input' => 62842880,
        ],
        2 => [
            'input' => 57600000,
        ]
    ];
    protected $ingredients = [];
    protected $doughs = [];

    protected function processPayload($payload)
    {
        return explode(PHP_EOL, $payload);
    }

    protected function initPart()
    {
        ini_set('memory_limit', '512M');
        $this->ingredients = [];
        $this->doughs      = [];
    }

    protected function testOne($input)
    {
        $input = [
            'Butterscotch: capacity -1, durability -2, flavor 6, texture 3, calories 8',
            'Cinnamon: capacity 2, durability 3, flavor -2, texture -1, calories 3',
        ];
        $this->addIngredients($input);
        $this->createDoughs();
        return $this->getBestDough()->getScore();
    }

    protected function testTwo($input)
    {
        $input = [
            'Butterscotch: capacity -1, durability -2, flavor 6, texture 3, calories 8',
            'Cinnamon: capacity 2, durability 3, flavor -2, texture -1, calories 3',
        ];
        $this->addIngredients($input);
        $this->createDoughs();
        return $this->getBestDoughWithCalories(500)->getScore();
    }

    protected function addIngredients(array $ingredients)
    {
        foreach ($ingredients as $ingredient) {
            $this->ingredients[] = new Ingredient($ingredient);
        }
    }

    protected function createDoughs()
    {
        $numberOfIngredients = count($this->ingredients);
        $this->getDoughs($numberOfIngredients-1);
    }

    protected function getDoughs($level, $remaining = 100, $ingredients = [])
    {
        if ($level === 0) {
            $ingredients[$level] = $remaining;
            $this->doughs[] = new Dough($this->ingredients, $ingredients);
            return;
        }
        for ($i = 1; $i <= $remaining - $level; $i++) {
            $ingredients[$level] = $i;
            $this->getDoughs($level-1, $remaining-$i, $ingredients);
        }
    }

    protected function getBestDough()
    {
        foreach ($this->doughs as $dough) {
            if (isset($leader) === false || $dough->getScore() > $leader->getScore()) {
                $leader = $dough;
            }
        }

        return $leader;
    }

    protected function getBestDoughWithCalories($calories)
    {
        foreach ($this->doughs as $dough) {
            if ($dough->getCalories() === $calories &&
                (isset($leader) === false || $dough->getScore() > $leader->getScore())) {
                $leader = $dough;
            }
        }

        return $leader;
    }

    protected function partOne($input)
    {
        $this->addIngredients($input);
        $this->createDoughs();
        return $this->getBestDough()->getScore();
    }

    protected function partTwo($input)
    {
        $this->addIngredients($input);
        $this->createDoughs();
        return $this->getBestDoughWithCalories(500)->getScore();
    }
}
