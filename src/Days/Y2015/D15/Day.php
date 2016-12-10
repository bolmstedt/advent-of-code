<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D15;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Science for Hungry People';
    protected $ingredients = [];
    protected $doughs = [];

    protected function processPayload($payload)
    {
        return explode(PHP_EOL, $payload);
    }

    protected function initPart()
    {
        $this->ingredients = [];
        $this->doughs = [];
    }

    protected function addIngredients(array $ingredients)
    {
        foreach ($ingredients as $ingredient) {
            $this->ingredients[] = new Helpers\Ingredient($ingredient);
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
            $this->doughs[] = new Helpers\Dough($this->ingredients, $ingredients);

            return;
        }

        for ($i = 1; $i <= $remaining - $level; ++$i) {
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
