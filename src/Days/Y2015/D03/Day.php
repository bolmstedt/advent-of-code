<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D03;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Perfectly Spherical Houses in a Vacuum';
    protected $testData = [
        'one' => [
            '>' => 2,
            '^>v<' => 4,
            '^v^v^v^v^v' => 2,
        ],
        'two' => [
            '^v' => 3,
            '^>v<' => 3,
            '^v^v^v^v^v' => 11,
        ],
    ];
    protected $position;
    protected $houses;

    protected function reset($sleds)
    {
        $this->houses = [];
        $this->position = [];

        foreach ($sleds as $sled) {
            $this->position[$sled] = [
                'x' => 0,
                'y' => 0,
            ];
            $this->visitHouseAs($sled);
        }

        if (count($sleds) === 1) {
            $sleds[] = $sleds[0];
        }

        return $sleds;
    }

    protected function getVisitedHouses()
    {
        return count($this->houses);
    }

    protected function deliverToHouses(array $sleds, $input)
    {
        $sleds = $this->reset($sleds);
        $length = strlen($input);

        for ($i = 0; $i < $length; ++$i) {
            $sled = $sleds[$i % 2];
            $this->movePosition($sled, $input[$i]);
            $this->visitHouseAs($sled);
        }
    }

    protected function movePosition($sled, $towards)
    {
        switch ($towards) {
            case '^':
                $this->position[$sled]['y']++;
                break;
            case '>':
                $this->position[$sled]['x']++;
                break;
            case 'v':
                $this->position[$sled]['y']--;
                break;
            case '<':
                $this->position[$sled]['x']--;
                break;
        }
    }

    protected function visitHouseAs($sled)
    {
        $position = implode(',', $this->position[$sled]);

        if (isset($this->houses[$position]) === false) {
            $this->houses[$position] = 0;
        }

        ++$this->houses[$position];
    }

    protected function partOne($input)
    {
        $this->deliverToHouses(['santa'], $input);

        return $this->getVisitedHouses();
    }

    protected function partTwo($input)
    {
        $this->deliverToHouses(['santa', 'robosanta'], $input);

        return $this->getVisitedHouses();
    }
}
