<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D13;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Knights of the Dinner Table';
    protected $guests = [];
    protected $seatings = [];
    protected $seatingHappiness = [];

    protected function processPayload($payload)
    {
        return explode(PHP_EOL, $payload);
    }

    protected function initPart()
    {
        $this->guests = [];
        $this->seatings = [];
        $this->seatingHappiness = [];
    }

    protected function addGuests($input)
    {
        foreach ($input as $value) {
            $this->addGuest($value);
        }
    }

    protected function addGuest($value)
    {
        preg_match('/^(?<who>.*) would (?<what>.*) (?<amount>\\d*) happiness units by sitting next to (?<whom>.*)\.$/', $value, $matches);
        $this->guests[$matches['who']][$matches['whom']] = ($matches['what'] === 'gain') ? (int) $matches['amount'] : - (int) $matches['amount'];
    }

    protected function addYou()
    {
        foreach (array_keys($this->guests) as $guest) {
            $this->guests[$guest]['You'] = 0;
            $this->guests['You'][$guest] = 0;
        }
    }

    protected function generateSeatings()
    {
        $this->permute(array_keys($this->guests));
    }

    protected function permute($items, $permutations = [])
    {
        $length = count($items);

        if ($length === 0) {
            $this->seatings[] = $permutations;

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

    protected function calculateSeatings()
    {
        foreach ($this->seatings as $seating) {
            $lastGuest = end($seating);
            $happiness = 0;

            foreach ($seating as $guest) {
                $happiness += $this->guests[$lastGuest][$guest];
                $happiness += $this->guests[$guest][$lastGuest];
                $lastGuest = $guest;
            }

            $this->seatingHappiness[] = $happiness;
        }
    }

    protected function getHappiestSeating()
    {
        return max($this->seatingHappiness);
    }

    protected function partOne($input)
    {
        $this->addGuests($input);
        $this->generateSeatings();
        $this->calculateSeatings();

        return $this->getHappiestSeating();
    }

    protected function partTwo($input)
    {
        $this->addGuests($input);
        $this->addYou();
        $this->generateSeatings();
        $this->calculateSeatings();

        return $this->getHappiestSeating();
    }
}
