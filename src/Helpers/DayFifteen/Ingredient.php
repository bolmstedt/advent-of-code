<?php

namespace Aoc\Helpers\DayFifteen;

final class Ingredient
{
    protected $name;
    protected $capacity;
    protected $durability;
    protected $flavor;
    protected $texture;
    protected $calories;

    public function __construct($input)
    {
        preg_match('/(?<name>.*): capacity (?<capacity>-?\\d*), durability (?<durability>-?\\d*), flavor (?<flavor>-?\\d*), texture (?<texture>-?\\d*), calories (?<calories>-?\\d*)/', $input, $matches);
        $this->name       = $matches['name'];
        $this->capacity   = (int) $matches['capacity'];
        $this->durability = (int) $matches['durability'];
        $this->flavor     = (int) $matches['flavor'];
        $this->texture    = (int) $matches['texture'];
        $this->calories   = (int) $matches['calories'];
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function getDurability()
    {
        return $this->durability;
    }

    public function getFlavor()
    {
        return $this->flavor;
    }

    public function getTexture()
    {
        return $this->texture;
    }

    public function getCalories()
    {
        return $this->calories;
    }
}
