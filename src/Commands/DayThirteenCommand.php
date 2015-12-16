<?php

namespace Aoc\Commands;

final class DayThirteenCommand extends DayCommandAbstract
{
    protected $day          = 13;
    protected $description  = 'Knights of the Dinner Table';
    protected $testFunction = [
        1 => 'testOne',
        2 => 'testTwo',
    ];
    protected $testData     = [
        1 => [
            'input' => 330,
        ],
        2 => [
            'input' => 286,
        ]
    ];

    protected $guests           = [];
    protected $seatings         = [];
    protected $seatingHappiness = [];

    protected function processPayload($payload)
    {
        return explode(PHP_EOL, $payload);
    }

    protected function initPart()
    {
        ini_set('memory_limit', '512M');
        $this->guests           = [];
        $this->seatings         = [];
        $this->seatingHappiness = [];
    }

    protected function testOne($input)
    {
        $input = [
            'Alice would gain 54 happiness units by sitting next to Bob.',
            'Alice would lose 79 happiness units by sitting next to Carol.',
            'Alice would lose 2 happiness units by sitting next to David.',
            'Bob would gain 83 happiness units by sitting next to Alice.',
            'Bob would lose 7 happiness units by sitting next to Carol.',
            'Bob would lose 63 happiness units by sitting next to David.',
            'Carol would lose 62 happiness units by sitting next to Alice.',
            'Carol would gain 60 happiness units by sitting next to Bob.',
            'Carol would gain 55 happiness units by sitting next to David.',
            'David would gain 46 happiness units by sitting next to Alice.',
            'David would lose 7 happiness units by sitting next to Bob.',
            'David would gain 41 happiness units by sitting next to Carol.',
        ];

        $this->addGuests($input);
        $this->generateSeatings();
        $this->calculateSeatings();
        return $this->getHappiestSeating();
    }

    protected function testTwo($input)
    {
        $input = [
            'Alice would gain 54 happiness units by sitting next to Bob.',
            'Alice would lose 79 happiness units by sitting next to Carol.',
            'Alice would lose 2 happiness units by sitting next to David.',
            'Bob would gain 83 happiness units by sitting next to Alice.',
            'Bob would lose 7 happiness units by sitting next to Carol.',
            'Bob would lose 63 happiness units by sitting next to David.',
            'Carol would lose 62 happiness units by sitting next to Alice.',
            'Carol would gain 60 happiness units by sitting next to Bob.',
            'Carol would gain 55 happiness units by sitting next to David.',
            'David would gain 46 happiness units by sitting next to Alice.',
            'David would lose 7 happiness units by sitting next to Bob.',
            'David would gain 41 happiness units by sitting next to Carol.',
        ];

        $this->addGuests($input);
        $this->addYou();
        $this->generateSeatings();
        $this->calculateSeatings();
        return $this->getHappiestSeating();
    }

    protected function addGuests($input)
    {
        foreach ($input as $value) {
            $this->addGuest($value);
        }
    }

    protected function addGuest($value)
    {
        preg_match('/(?<who>.*) would (?<what>.*) (?<amount>\\d*) happiness units by sitting next to (?<whom>.*)\./', $value, $matches);
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
