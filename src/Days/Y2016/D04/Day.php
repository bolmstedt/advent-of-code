<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D04;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Security Through Obscurity';
    protected $testFunction = ['one' => 'partOne', 'two' => 'partTwoTest'];

    protected function processPayload($input)
    {
        return explode(PHP_EOL, $input);
    }

    protected function getSectorId($room)
    {
        preg_match('/\d+/', $room, $matches);

        return $matches[0];
    }

    protected function isReal($room)
    {
        preg_match('/^(.*)-\d+\[([a-z]+)\]/', $room, $matches);
        $letters = str_split(str_replace('-', '', $matches[1]));
        $count = array_count_values($letters);
        array_multisort(array_values($count), SORT_DESC, array_keys($count), SORT_ASC, $count);
        $checksum = implode(array_slice(array_keys($count), 0, 5));

        return $checksum === $matches[2];
    }

    protected function getSectorIdSum($rooms)
    {
        return array_reduce($rooms, function ($carry, $room) {
            if ($this->isReal($room) === true) {
                $carry += $this->getSectorId($room);
            }

            return $carry;
        }, 0);
    }

    protected function partOne($input)
    {
        return $this->getSectorIdSum($input);
    }

    protected function findRealName($room)
    {
        $name = '';
        preg_match('/^(.*)-(\d+)/', $room, $matches);
        $offset = $matches[2];
        $encryptedName = str_replace('-', ' ', $matches[1]);
        $length = mb_strlen($encryptedName);

        for ($i = 0; $i < $length; ++$i) {
            $char = $encryptedName[$i];

            if ($char !== ' ') {
                $char = chr((ord($char) - 97 + $offset) % 26 + 97);
            }

            $name .= $char;
        }

        return $name;
    }

    protected function partTwoTest($input)
    {
        return $this->findRealName($input[0]);
    }

    protected function findIdOfRoom($rooms, $name)
    {
        foreach ($rooms as $room) {
            if ($this->isReal($room) === true) {
                if (strpos($this->findRealName($room), $name) !== false) {
                    return $this->getSectorId($room);
                }
            }
        }
    }

    protected function partTwo($input)
    {
        return $this->findIdOfRoom($input, 'northpole object storage');
    }
}
