<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D20;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Infinite Elves and Infinite Houses';
    protected $testData = [
        'one' => [
            10 => 1,
            30 => 2,
            40 => 3,
            70 => 4,
            60 => 4,
            120 => 6,
            80 => 6,
            150 => 8,
            130 => 8,
        ],
        'two' => [
            500 => 24,
            120 => 6,
        ],
    ];
    protected $smallestHouse;

    protected function presentsAtHouse($number)
    {
        $presents = 1;

        for ($i = 2; $i <= $number; ++$i) {
            if ($number % $i === 0) {
                $presents += $i;
            }
        }

        return $presents;
    }

    protected function presentsAtHouseLimit($number)
    {
        $presents = 1;

        for ($i = 2; $i <= $number; ++$i) {
            if ($number % $i === 0 && $number / $i < 50) {
                $presents += $i;
            }
        }

        return $presents;
    }

    protected function combinations($presentsPerElf, $function, $target, $numbers, $configuration = [])
    {
        if (empty($configuration) === false) {
            $required = $target / $presentsPerElf;
            $house = array_product($configuration);

            if (isset($this->smallestHouse) === false || $house < $this->smallestHouse && $house > $required / 5) {
                $presents = $this->$function($house);

                if ($required <= $presents) {
                    $this->smallestHouse = $house;
                }
            }
        }

        $length = count($numbers);

        for ($i = 0; $i < $length; ++$i) {
            if (count($numbers) > 0) {
                list($number) = array_splice($numbers, 0, 1);
                $this->combinations($presentsPerElf, $function, $target, $numbers, array_merge($configuration, [$number]));
            }
        }
    }

    protected function partOne($input)
    {
        $numbers = range(1, 14);
        $this->smallestHouse = null;
        $this->combinations(10, 'presentsAtHouse', $input, $numbers);

        return $this->smallestHouse;
    }

    protected function partTwo($input)
    {
        $numbers = range(2, 13);
        $this->smallestHouse = null;
        $this->combinations(11, 'presentsAtHouseLimit', $input, $numbers);

        return $this->smallestHouse;
    }
}
