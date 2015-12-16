<?php

namespace Aoc\Helpers\DayFifteen;

final class Dough
{
    protected $ingredients = [];
    protected $quantities  = [];
    protected $capacity    = 0;
    protected $durability  = 0;
    protected $flavor      = 0;
    protected $texture     = 0;
    protected $calories    = 0;
    protected $score;

    public function __construct(array $ingredients, array $quantities)
    {
        foreach ($ingredients as $ingredient) {
            $this->addIngredient($ingredient);
        }
        foreach ($quantities as $quantity) {
            $this->quantities[]  = $quantity;
        }
    }

    public function addIngredient(Ingredient $ingredient)
    {
        $this->ingredients[] = $ingredient;
    }

    public function getScore()
    {
        if (empty($this->score) === false) {
            return $this->score;
        }

        if (array_sum($this->quantities) !== 100) {
            return 0;
        }

        foreach ($this->ingredients as $index => $ingredient) {
            $amount = $this->quantities[$index];
            $this->capacity   += $amount * $ingredient->getCapacity();
            $this->durability += $amount * $ingredient->getDurability();
            $this->flavor     += $amount * $ingredient->getFlavor();
            $this->texture    += $amount * $ingredient->getTexture();
        }

        $capacity   = max(0, $this->capacity);
        $durability = max(0, $this->durability);
        $flavor     = max(0, $this->flavor);
        $texture    = max(0, $this->texture);
        return $this->score = $capacity * $durability * $flavor * $texture;
    }

    public function getCalories()
    {
        if (empty($this->calories) === false) {
            return $this->calories;
        }

        if (array_sum($this->quantities) !== 100) {
            return 0;
        }

        foreach ($this->ingredients as $index => $ingredient) {
            $amount = $this->quantities[$index];
            $this->calories   += $amount * $ingredient->getCalories();
        }

        return $this->calories;
    }
}
