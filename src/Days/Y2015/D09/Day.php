<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D09;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'All in a Single Night';
    protected $locations = [];
    protected $routes = [];
    protected $routeLengths = [];

    protected function processPayload($payload)
    {
        return explode(PHP_EOL, $payload);
    }

    protected function initPart()
    {
        $this->locations = [];
        $this->routes = [];
        $this->routeLengths = [];
    }

    protected function addLocations($input)
    {
        foreach ($input as $value) {
            $this->addLocation($value);
        }
    }

    protected function addLocation($value)
    {
        preg_match('/(?<org>.*) to (?<dest>.*) = (?<distance>\\d*)/', $value, $matches);
        $this->locations[$matches['org']][$matches['dest']] =
        $this->locations[$matches['dest']][$matches['org']] = (int) $matches['distance'];
    }

    protected function generateRoutes()
    {
        $this->permute(array_keys($this->locations));
    }

    protected function permute($items, $permutations = [])
    {
        $length = count($items);

        if ($length === 0) {
            $this->routes[] = $permutations;

            return;
        }

        for ($i = $length - 1; $i >= 0; --$i) {
            $newItems = $items;
            $newPermutations = $permutations;
            list($item) = array_splice($newItems, $i, 1);
            array_unshift($newPermutations, $item);
            $this->permute($newItems, $newPermutations);
        }
    }

    protected function calculateRoutes()
    {
        foreach ($this->routes as $route) {
            unset($lastLocation);
            $length = 0;

            foreach ($route as $location) {
                if (isset($lastLocation) === true) {
                    $length += $this->locations[$lastLocation][$location];
                }

                $lastLocation = $location;
            }

            $this->routeLengths[] = $length;
        }
    }

    protected function getShortestRoute()
    {
        return min($this->routeLengths);
    }

    protected function getLongestRoute()
    {
        return max($this->routeLengths);
    }

    protected function partOne($input)
    {
        $this->addLocations($input);
        $this->generateRoutes();
        $this->calculateRoutes();

        return $this->getShortestRoute();
    }

    protected function partTwo($input)
    {
        $this->addLocations($input);
        $this->generateRoutes();
        $this->calculateRoutes();

        return $this->getLongestRoute();
    }
}
